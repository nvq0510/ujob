<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskImageController extends Controller
{
    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        $images = $task->images;
        return view('admin.tasks.images.index', compact('task', 'images'));
    }
    
    public function create(Task $task)
    {
        return view('admin.tasks.images.create', compact('task'));
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Đặt tên file dựa trên task_id và thời gian hiện tại
                $filename = 'task_' . $task->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Lưu file với tên đã tạo trong thư mục 'task_images'
                $path = $image->storeAs('task_images', $filename, 'public');
                
                // Tạo bản ghi trong bảng task_images với đường dẫn
                $task->images()->create(['path' => $path]);
            }
        }
    
        return redirect()->route('admin.tasks.images.index', $task->id)
                        ->with('success', 'Images uploaded successfully.');
    }
    


    public function destroy(Task $task, TaskImage $image)
    {
        // Xóa file vật lý
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Xóa bản ghi trong cơ sở dữ liệu
        $image->delete();

        return redirect()->route('admin.tasks.images.index', $task->id)
                        ->with('success', 'Image deleted successfully.');
    }

    public function bulkDestroy(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $imageIds = $request->input('image_ids', []);

        // Fetch the images based on selected IDs
        $images = TaskImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            // Delete the physical file
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            // Delete the record in the database
            $image->delete();
        }

        return redirect()->route('admin.tasks.show', $taskId)->with('success', 'Selected images deleted successfully.');
    }

}

