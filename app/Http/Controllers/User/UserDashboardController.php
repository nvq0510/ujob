<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;



class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Lấy ngày từ yêu cầu hoặc mặc định là ngày hiện tại
        $work_date = $request->input('work_date', Carbon::now()->format('Y-m-d'));
        $tasks = $user->tasks()
            ->with('workplace')
            ->whereDate('work_date', $work_date)
            ->get();

        // Thêm tính năng lọc theo tháng
        $work_month = $request->input('work_month');
        if ($work_month) {
            $tasks = $user->tasks()
                ->with('workplace')
                ->whereYear('work_date', Carbon::parse($work_month)->year)
                ->whereMonth('work_date', Carbon::parse($work_month)->month)
                ->get();
        }

        // Truyền dữ liệu cho view
        return view('user.dashboard', compact('tasks', 'work_date', 'work_month'));
    }
}
