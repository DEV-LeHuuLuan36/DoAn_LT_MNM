<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Kiểm tra trạng thái tài khoản theo thời gian thực (Real-time force logout).
     * Nếu tài khoản bị Admin khóa (is_locked == true/1), lập tức đăng xuất cưỡng bức
     * và chuyển hướng về trang đăng nhập kèm thông báo lỗi.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user && ($user->is_locked || (bool) $user->fresh()?->is_locked)) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa bởi Quản trị viên.'])
                    ->with('error', 'Tài khoản của bạn đã bị khóa bởi Quản trị viên.');
            }
        }

        return $next($request);
    }
}
