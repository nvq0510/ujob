<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Xác thực dữ liệu từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:11',
            'zipcode' => 'nullable|string|max:7',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => 'active',  // hoặc 'inactive' nếu bạn muốn tài khoản cần được kích hoạt
            'role' => 'user', // mặc định là user
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        Auth::login($user);

        // Chuyển hướng đến dashboard
        return redirect()->route('user.dashboard')->with('success', 'Account created and logged in successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['status' => 'アクアウントが有効ではありません。']);
            }
            $this->logLoginAttempt($request, $user);
            return $this->redirectUserBasedOnRole($user);
        }
    
        return back()->withErrors(['email' => 'メールアドレスまたはパスワードが正しくありません。']);
    }
    
    protected function logLoginAttempt(Request $request, $user)
    {
        // You can use Laravel's logging system to log information or save it to the database
        \Log::info('User logged in', [
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'timestamp' => now()
        ]);
    }
    
    /**
     * Redirect the user based on their role.
     */
    protected function redirectUserBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
