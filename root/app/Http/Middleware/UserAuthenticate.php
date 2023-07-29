<?php

namespace App\Http\Middleware;

use App\Enums\UserEnums;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard()->check()) {
            if (!$request->expectsJson()) {
                Auth::logout();
                Session::flash('contentFail', 'Bạn phải đăng nhập mới có thể sử dụng tính năng này!'); 
                Session::flash('titleFail', 'Cảnh báo!');
                return redirect()->route('login');
            }
            return response()->json([
                'status'  => config('constants.ERROR_STATUS.FAIL_AND_RELOAD'),
                'title'   => 'Cảnh báo!',
                'message' => 'Bạn phải đăng nhập mới có thể sử dụng tính năng này!',
            ]);
        }
        if(!empty(Auth::user()) && Auth::user()->status != UserEnums::STATUS_ACTIVE ){
            if (!$request->expectsJson()) {
                Auth::logout();
                Session::flash('contentFail', 'Tài khoản của bạn đã bị khóa!'); 
                Session::flash('titleFail', 'Cảnh báo!');
                return redirect()->route('login');
            }
            return response()->json([
                'status'  => config('constants.ERROR_STATUS.FAIL_AND_RELOAD'),
                'title'   => 'Cảnh báo!',
                'message' => 'Tài khoản của bạn đã bị khóa!',
            ]);
        }
        return $next($request);
    }
}
