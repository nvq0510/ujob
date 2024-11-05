<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        // Lấy số liệu về nhân viên
        $totalEmployees = User::count();
        $activeEmployees = User::where('status', 'active')->count();
        $inactiveEmployees = User::where('status', 'inactive')->count();
        $workingEmployees = Task::whereDate('work_date', Carbon::today())
            ->where('status', '進行中')
            ->distinct('user_id')
            ->count('user_id');
            
        $totalTasks = Task::count();

        // Lấy số liệu về công việc theo trạng thái
        $taskStatusCount = Task::selectRaw("
            COUNT(CASE WHEN status = '未開始' THEN 1 END) as not_started,
            COUNT(CASE WHEN status = '進行中' THEN 1 END) as in_progress,
            COUNT(CASE WHEN status = '完了' THEN 1 END) as completed,
            COUNT(CASE WHEN status = 'キャンセル' THEN 1 END) as cancelled
        ")->first()->toArray();

        // Tính phần trăm của từng trạng thái
        $taskStatusPercent = [
            'not_started' => $totalTasks > 0 ? ($taskStatusCount['not_started'] / $totalTasks) * 100 : 0,
            'in_progress' => $totalTasks > 0 ? ($taskStatusCount['in_progress'] / $totalTasks) * 100 : 0,
            'completed' => $totalTasks > 0 ? ($taskStatusCount['completed'] / $totalTasks) * 100 : 0,
            'cancelled' => $totalTasks > 0 ? ($taskStatusCount['cancelled'] / $totalTasks) * 100 : 0,
        ];

        // Lấy danh sách công việc gần đây (có thể lấy 5 công việc mới nhất)
        $recentTasks = Task::with(['user', 'workplace'])
            ->orderBy('work_date', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees', 'activeEmployees', 'inactiveEmployees', 'workingEmployees', 
            'taskStatusCount', 'taskStatusPercent', 'recentTasks'
        ));
    }

    public function getTaskStatusData()
    {
        $totalTasks = Task::count();

        // Lấy số liệu công việc theo trạng thái
        $taskStatusCount = Task::selectRaw("
            COUNT(CASE WHEN status = '未開始' THEN 1 END) as not_started,
            COUNT(CASE WHEN status = '進行中' THEN 1 END) as in_progress,
            COUNT(CASE WHEN status = '完了' THEN 1 END) as completed,
            COUNT(CASE WHEN status = 'キャンセル' THEN 1 END) as cancelled
        ")->first()->toArray();

        $taskStatusPercent = [
            'not_started' => $totalTasks > 0 ? ($taskStatusCount['not_started'] / $totalTasks) * 100 : 0,
            'in_progress' => $totalTasks > 0 ? ($taskStatusCount['in_progress'] / $totalTasks) * 100 : 0,
            'completed' => $totalTasks > 0 ? ($taskStatusCount['completed'] / $totalTasks) * 100 : 0,
            'cancelled' => $totalTasks > 0 ? ($taskStatusCount['cancelled'] / $totalTasks) * 100 : 0,
        ];

        return response()->json($taskStatusPercent);
    }
    

}
