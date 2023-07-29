<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
                Session::flash('contentFail', 'Bạn phải đăng nhập mới có thể sử dụng tính năng này!'); 
                Session::flash('titleFail', 'Cảnh báo!');
                return route('login');
        }
    }
}
