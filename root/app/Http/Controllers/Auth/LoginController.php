<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Contracts\UserServiceInterface;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userService;

    /**
     * UserServiceInterface constructor.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function email()
    {
        return 'email';
    }

    public function showLogin(Request $request)
    {
        return view('users.auth.login');
    }
   
    public function authLogin(LoginUserRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $rememberToken = $request->input('remember_me') ? true : false;
        
        if (!Auth::attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            Session::flash('contentFail', 'Đăng nhập thất bại!'); 
            Session::flash('titleFail', 'Đăng nhập'); 
            return redirect()->back();
        }
        $status =  auth()->user()->status;
        if($status === UserEnums::STATUS_INACTIVE || $status === UserEnums::STATUS_BLOCK){
            Session::flash('contentFail', 'Tài khoản của bạn đang bị khoá!');
            Session::flash('titleFail', 'Đăng nhập');
            Auth::logout();
            return redirect()->back();
        }
        Session::flash('contentSuccess', 'Đăng nhập thành công!'); 
        Session::flash('titleSuccess', 'Đăng nhập'); 
        if (!auth()->user()->is_first == UserEnums::IS_FIRST_LOGIN){
            return redirect()->intended('/');
        }
        $this->userService->updateIsFirst(auth()->user()->id);
        return redirect()->route('user.show');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
