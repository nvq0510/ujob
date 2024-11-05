<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Hiển thị form yêu cầu quên mật khẩu
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        // Gửi link đặt lại mật khẩu
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        // Nếu gửi thành công, cập nhật thêm thông tin IP và User-Agent
        if ($status === Password::RESET_LINK_SENT) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->update([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'expires_at' => now()->addMinutes(config('auth.passwords.users.expire', 60))
                ]);
        }
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Xử lý đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}