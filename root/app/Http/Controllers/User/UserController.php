<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeInfoUserRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
class UserController extends Controller
{
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

    public function showUser()
    {
        if (auth()->check()) {
            $data = $this->userService->showUser(auth()->user()->id);
            $read = count($data->borrow->unique('book_id'));
            $contributed = $data->user_book->pluck('quantity')->sum();
            return view('users.information.infor', compact('data','read', 'contributed'));
        } else {
            return view('users.auth.login');
        }

    }
    
    public function editInfoUser(ChangeInfoUserRequest $request)
    {
        $this->userService->editInfoUser($request);
        return response()->json([
            'status'  => 200,
            'title'   => 'Thông tin tài khoản',
            'message' => 'Thông tin tài khoản đã cập nhật thành công.',
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->userService->changePasswordUser($request);
        return response()->json([
            'status'  => 200,
            'title'   => 'Mật khẩu',
            'message' => 'Thay đổi mật khẩu thành công.',
        ]);
    }

    public function loginUser()
    {
        return view('users.auth.login');
    }

    // Show form forgot password
    public function forgotPassword(Request $request)
    {
        return $this->userService->forgotPassword($request);    
    }
 
}