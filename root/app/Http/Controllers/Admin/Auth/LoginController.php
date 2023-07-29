<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()){
            return redirect(route('dashboard'));
        }
        return view('admin.auth.login');
    }

    public function login(AdminAuthRequest $request)
    {
        if (Auth::guard('admin')->check()){
            return redirect(route('dashboard'));
        }

        $remember = $request->has('remember') ? TRUE : FALSE;
        $credentials = $request->only(['email', 'password']);
        if (!$this->guard()->attempt($credentials, $remember)) {
            Session::flash('message', 'Tài khoản hoặc mật khẩu không chính xác');
            Session::flash('class', 'bg-gradient-warning text-white');
            return redirect()->back()->withInput();
        } 
        Session::flash('message', 'Đăng nhập thành công');
        Session::flash('class', 'bg-gradient-success text-white');
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return redirect()->route('admin.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
