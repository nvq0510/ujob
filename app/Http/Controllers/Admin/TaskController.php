<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $workplaces = Workplace::all();
        $query = Task::with(['user', 'workplace']);
    
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('workplace_id')) {
            $query->where('workplace_id', $request->workplace_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $query->orderByRaw("FIELD(status, '未開始') DESC")
              ->orderBy('work_date', 'desc');
    
        $tasks = $query->paginate(10);
    
        return view('admin.tasks.index', compact('tasks', 'users', 'workplaces'));
    }
    
    public function create(Request $request)
    {
        $users = User::all();
        $workplaces = Workplace::all();
        return view('admin.tasks.create', compact('users', 'workplaces'));
    }
    

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'workplace_id' => 'required|exists:workplaces,id',
                'work_date' => 'required|date',
                'shift' => 'nullable|string',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'status' => 'required|in:未開始,進行中,完了,キャンセル',
                'description' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);
    
            $task = Task::create($request->all());
    
            return redirect()->route('admin.tasks.index')->with('success', 'タスクが追加されしました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'タスクの作成中にエラーが発生しました: ' . $e->getMessage()]);
        }
    }

    public function show($taskId)
    {
        $task = Task::findOrFail($taskId);
        $images = $task->images; 
        return view('admin.tasks.show', compact('task', 'images'));
    }
    
    public function edit($id)
    {
        $task = Task::with('images')->findOrFail($id);
        $users = User::all();
        $workplaces = Workplace::all();
        return view('admin.tasks.edit', compact('task', 'users', 'workplaces'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'workplace_id' => 'required|exists:workplaces,id',
            'work_date' => 'required|date',
            'shift' => 'nullable|string|max:50',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $task->update($request->only(['user_id', 'workplace_id', 'work_date', 'shift', 'status', 'description', 'notes', 'start_time', 'end_time']));
    
            // Handle image deletion
            if ($request->has('delete_image_ids')) {
                foreach ($request->delete_image_ids as $imageId) {
                    $image = $task->images()->find($imageId);
                    if ($image) {
                        if (Storage::disk('public')->exists($image->path)) {
                            Storage::disk('public')->delete($image->path);
                        }
                        $image->delete();
                    }
                }
            }
    
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = 'task_' . $task->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('task_images', $filename, 'public');
                    
                    $task->images()->create(['path' => $path]);
                }
            }
    
            return redirect()->route('admin.tasks.show', $task->id)->with('success', 'タスクが正常に更新されました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'タスクの更新中にエラーが発生しました: ' . $e->getMessage()]);
        }
    }
    

    public function destroy($id)
    {
        $task = Task::with('images')->findOrFail($id);
        foreach ($task->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'タスクが削除されました。');
    }

    public function getCalendarData(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $taskCounts = Task::selectRaw('DATE(work_date) as date, COUNT(*) as count')
            ->whereBetween('work_date', [$start, $end])
            ->groupBy('date')
            ->get();

        return response()->json($taskCounts);
    }

}