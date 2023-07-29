<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Jobs\Admin\SendUserCreateMail;
use Illuminate\Http\Request;
use App\Enums\UserEnums;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\ChangeUserStatusRequest;
use App\Jobs\Admin\SendStatusChangeMail;

use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    /**
     * Parameter
     *
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * UserServiceInterface constructor.
     *
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $users = $this->userService->index($data)->appends($data);
        if (!empty($data)) {
            if($users->lastPage() < $users->currentPage()) {
                Paginator::currentPageResolver(function () {
                    return UserEnums::DEFAULT_PAGE;
                });
                $users = $this->userService->index($data)->appends($data);
            }
            return view('admin.users.table_user', [
                'users' => $users,
            ]);
        }
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['password'] = randomString(config('constants.DEFAULT_PASSWORD_LENGTH'));
        try {
            $user = $this->userService->store($data);
            if (!$user) {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thêm người dùng thất bại!']);
            }
            DB::commit();
            $mailData = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            dispatch(new SendUserCreateMail($mailData));

            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Thêm người dùng thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thêm người dùng thất bại!']);
        }
    }

    public function show($id)
    {
        $data = $this->userService->show($id);
        $read = count($data->borrow->unique('book_id'));
        $contributed = $data->user_book->pluck('quantity')->sum();
        return view('admin.users.details', compact('data','read', 'contributed'));
    }

    public function showEditModal($id)
    {
        $data = $this->userService->show($id);
        if (!$data) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Lỗi!']);
        }
        return response()->json($data);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $user = $this->userService->update($request, $id);
            if (empty($user))
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Chỉnh sửa thất bại. Vui lòng kiểm tra lại!']);

            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Chỉnh sửa thành công!']);
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Chỉnh sửa thất bại!']);
        }
    }

    public function unBlock(Request $request)
    {
        $email = $request->input('email');
        try {
            $user = $this->userService->unBlock($request);
            if (empty($user)) {
                return response()->json([
                    'status' => config('constants.ERROR_STATUS.FAIL'),
                    'message' => 'Mở khóa người dùng thất bại!'
                ]);
            } else {
                $mailData = [
                    'subject' => 'Tài khoản',
                    'status' => 'mở khóa',
                    'reason' => 'Tài khoản của bạn đã được mở khóa',
                    'email' => $email,
                ];
                dispatch(new SendStatusChangeMail($mailData));
                return response()->json([
                    'status' => config('constants.ERROR_STATUS.SUCCESS'),
                    'message' => 'Mở khóa người dùng thành công',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('constants.ERROR_STATUS.FAIL'),
                'message' => 'Liên kết không tồn tại'
            ]);
        }

    }

    public function block(ChangeUserStatusRequest $request)
    {
        $email = $request->input('email');
        $reason = $request->input('reason');
        try {
            $user = $this->userService->block($request);
            if (empty($user)) {
                return response()->json([
                    'status' => config('constants.ERROR_STATUS.FAIL'),
                    'message' => 'Khóa người dùng thất bại'
                ]);
            } else {
                $mailData = [
                    'subject' => 'Tài khoản',
                    'status' => 'khóa',
                    'reason' => $reason,
                    'email' => $email,
                ];
                dispatch(new SendStatusChangeMail($mailData));
                return response()->json([
                    'status' => config('constants.ERROR_STATUS.SUCCESS'),
                    'message' => 'Khóa người dùng thành công',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('constants.ERROR_STATUS.FAIL'),
                'message' => 'Liên kết không tồn tại'
            ]);
        }
    }

    public function changePassword(Request $request, $id)
    {
        try {
            $user = $this->userService->changePassword($request, $id);
            if ($user) {
                return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Thay đổi mật khẩu thành công. Vui lòng kiểm tra email!']);
            } else {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thay đổi mật khẩu thất bại!']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thay đổi mật khẩu thất bại!']);
        }
    }

    public function destroy(ChangeUserStatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $user = $this->userService->destroy($data);
            if (!$user) {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Xoá người dùng thất bại!']);
            }
            DB::commit();
            $mailData = [
                'subject' => 'Tài khoản',
                'status' => 'xóa',
                'reason' => $data['reason'],
                'email' => $data['email'],
            ];
            dispatch(new SendStatusChangeMail($mailData));
            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Xoá người dùng thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Xoá người dùng thất bại!']);
        }
    }
}