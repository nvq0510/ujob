<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query để lấy danh sách người dùng
        $query = User::query();
    
        // Áp dụng bộ lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        // Áp dụng bộ lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // Phân trang kết quả
        $users = $query->paginate(10);
    
        // Truyền dữ liệu vào view
        return view('admin.users.index', compact('users'));
    }
    

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:11',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('admin.users.index')->with('success', 'ユーザーが正常に作成されました。');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive',
        ]);
    
        $user->update($request->only(['name', 'email', 'phone', 'address', 'role', 'status']));
    
        return redirect()->route('admin.users.index')->with('success', 'ユーザーが正常に更新されました。');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'ユーザーが正常に削除されました。');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $tasks = $user->tasks()->with('workplace')->paginate(5); 
        return view('admin.users.show', compact('user', 'tasks'));
    }

    
}
