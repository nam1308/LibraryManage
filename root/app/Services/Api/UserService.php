<?php

namespace App\Services\Api;

use App\Jobs\Admin\SendChangeNewMail;
use App\Jobs\Admin\SendPassWordChangeMail;
use App\Jobs\ProcessSendNewPassword;
use App\Enums\UserEnums;
use App\Services\Contracts\UserServiceInterface;
use App\Repositories\Contracts\UserRepository;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserService implements UserServiceInterface
{
    use FileTrait;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * ExamplesController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
     public function getUser()
     {
        return $this->repository->where('status',UserEnums::STATUS_ACTIVE)->pluck('name','id');
     }

    public function index($request)
    {
        return $this->repository->paginateByFilters(
            ['status' => @$request['status'], 'search' => @$request['search'], 'withTrashed' => true],
            config('constants.DEFAULT_PAGINATION'),
            [],
            ['updated_at' => 'desc', 'employee_id' => 'desc']
        );
    }

    public function showUser($id)
    {
        // Get the first record
        return $this->repository->firstByWhere(['id' => $id], ['user_book','borrow']);
    }

    public function changePasswordUser($request)
    {
        $userId = auth()->user()->id;
        return $this->repository->update(['password' => Hash::make($request->new_password)], $userId);
    }

    public function show($id)
    {
        return $this->repository->firstByWhereWithTrashed(['id' => $id], ['user_book','borrow']);
    }

    public function store($request)
    {
        $path = 'files/';
        $file = $request['avatar'];
        $uploadFile = $this->upload($file, $path);
        if (!$uploadFile) return null;

        $request['avatar'] = $uploadFile;
        $request['password'] = Hash::make($request['password']);

        return $this->repository->create($request);
    }

    public function editInfoUser($request)
    {
        $user = $request->only([
            'avatar',
            'name',
            'birthday',
            'email',
            'gender',
            'address',
            'note',
        ]);
        $userId = auth()->user()->id;
        if (!empty($user['avatar'])) {

            $oldImage = $this->repository->find(auth()->user()->id, 'avatar');
            if (!empty($oldImage['avatar'])) {
                $this->delete($oldImage['avatar']);
            }

            $path = 'files';
            $file = $user['avatar'];
            $uploadFile = $this->upload($file, $path);
            $user['avatar'] = $uploadFile;
        }

        return $this->repository->update($user, $userId);
    }

    public function update($request, $id)
    {
        $user = User::find($id);
        if (empty($user)) return null;
        $oldMail = $user->email;

        if ($request->email && $request->email !== $user->email) {
            $websiteLink = url('/');
            dispatch(new SendChangeNewMail($user, $oldMail, $request->email, $websiteLink));
        }

        $user->update($request->all());
        $path = 'files/';
        $file = $request['avatar'];
        if ($file) {
            $uploadFile = $this->upload($file, $path);
            $user->avatar = $uploadFile;
            $user->save();
        }
        return $user;
    }

    public function block($request)
    {
        $user = User::find($request['user_id']);
        if (empty($user))
            return null;

        return $user->update(['status' => UserEnums::STATUS_BLOCK, 'reason' => $request['reason']]);
    }

    public function changePassword($request, $id)
    {
        $user = User::find($id);
        if (empty($user))
            return false;

        $newpass = $request->user_new_password;
        $user->password = Hash::make($newpass);
        $user->save();
        dispatch(new SendPassWordChangeMail($user, $newpass));
        return true;
    }

    function updateIsFirst($id)
    {
        return $this->repository->updateByFilters([['id', '=', $id]], ['is_first' => 0]);
    }

    function forgotPassword($request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users', 
            ],[
                'email.exists' => 'Email không tồn tại trên hệ thống!',
                'email.required' => 'Email không được để trống!',
                'email.email' => 'Email không đúng định dạng!',
            ]);            
            if ($validator->passes()) {
                // Generate new password
                $new_password = Str::random(8);

                // Update password
                $this->repository->updateByFilters([['email', '=', $data['email']]], ['password' => bcrypt($new_password)]);

                // Get user details
                $userDetails = $this->repository->firstByFilters([['email', '=', $data['email']]])->toArray();

                // Send Email To User
                $email = $data['email'];
                $messageData = ['name' => $userDetails['name'], 'email' => $email, 'password' => $new_password];

                // Jobs queue email
                dispatch(new ProcessSendNewPassword($messageData, $email));

                // Trả về phản hồi JSON thành công
                return response()->json(['type' => 'success', 'message' => 'Mật Khẩu Mới Đã Được Gửi Tới Email Của Bạn!'])
                    ->cookie('notification', true, 5);

            } else {
                // Trả về phản hồi JSON lỗi
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        } else {
            return view('users.auth.forgot_password');
        }
    }

    public function unBlock($request)
    {
        $user = User::find($request['user_id']);
        if (empty($user)) {
            return null;
        }
        return $user->update(['status' => UserEnums::STATUS_ACTIVE, 'reason' => $request['reason']]);
    }

    public function destroy($request)
    {
        $user = User::find($request['id']);
        if (empty($user))
            return null;
        
        $user->update(['status' => UserEnums::STATUS_INACTIVE, 'reason' => $request['reason']]);
        return $this->repository->delete($request['id']);
    }

    public function getStatistic($filters, $relation = [], $column = ['*'])
    {
        return $this->repository->getAllByFilters(
            ['field' => 'created_at', 'range' => [$filters['start'], $filters['end']], 'status' => $filters['status']],
            $relation, 
            [],
            ['id']
        );
    }

    public function getTopStatistic($startDate, $endDate, $limit){
        return $this->repository->getTopUsersByBookQuantityBetweenDates($startDate, $endDate, $limit);
    }
}