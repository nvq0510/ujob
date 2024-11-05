<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->with('workplace')->orderBy('work_date', 'desc')->get();
        return view('user.dashboard', compact('tasks'));
    }

    public function show(Task $task)
    {
        if ($task->user_id != Auth::id()) {
            abort(403, '権限がありません');
        }
        return view('user.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id != Auth::id()) {
            abort(403, '権限がありません');
        }

        $request->validate(['status' => 'required|in:未開始,進行中,完了']);
        
        if ($request->status == '進行中' && $task->status == '未開始') {
            $task->update(['status' => '進行中', 'start_time' => now()]);
        } elseif ($request->status == '完了' && $task->status == '進行中') {
            $task->update(['status' => '完了', 'end_time' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function uploadImages(Request $request, Task $task)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'task_' . $task->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('task_images'), $filename);
    
                // Store relative path in database
                $task->images()->create(['path' => 'task_images/' . $filename]);
            }
        }
    
        return redirect()->back()->with('success', '画像がアップロードされました。');
    }
    
    public function deleteImage(Task $task, TaskImage $image)
    {
        if ($task->user_id != Auth::id()) {
            abort(403, '権限がありません');
        }
    
        $imagePath = public_path($image->path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $image->delete();
    
        return redirect()->back()->with('success', '画像が削除されました。');
    }
    
}
