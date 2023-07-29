<?php

namespace App\Services\Api;

use App\Enums\BorrowerEnums;
use App\Jobs\User\SendMailBorrower;
use App\Jobs\User\SendMailBorrowerAdmin;
use App\Jobs\User\SendMailBorrowerAutoRenew;
use App\Jobs\User\SendMailBorrowerAutoRenewAdmin;
use App\Notifications\BookNotifications;
use App\Repositories\Contracts\AdminRepository;
use App\Services\Contracts\BorrowerServiceInterface;
use App\Repositories\Contracts\BorrowerRepository;
use App\Traits\FileTrait;
use App\Repositories\Contracts\BookRepository;
use App\Repositories\Contracts\NotificationRepository;
use App\Repositories\Contracts\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class BorrowerService implements BorrowerServiceInterface
{
    use FileTrait;
    protected $repository;
    protected $bookRepository;
    protected $notificationRepository;
    protected $adminRepository;
    protected $userRepository;

    public function __construct
    (
        BorrowerRepository $repository,
        BookRepository $bookRepository,
        NotificationRepository $notificationRepository,
        AdminRepository $adminRepository,
        UserRepository $userRepository
    )
    {
        $this->repository = $repository;
        $this->bookRepository = $bookRepository;
        $this->notificationRepository = $notificationRepository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    public function getallByUser($userId, $request)
    {
        $filters = [
            'status' => @$request['status'],
            'search' => @$request['search'],
            'user_id' => $userId,
        ];
        return $this->repository->paginateByFilters(
            $filters,
            config('constants.DEFAULT_PAGINATION'),
            ['book'],
            ['from_date' => 'desc']
        );
    }

    public function borrowBook($request, $id, $emailAdmin)
    {
        $user = Auth::user();
        $bookId = $request->book_id;
        if ($bookId) {
            // Đếm số lướng sách người dùng đã mượn
            $borrowedCount = $this->repository->countByFilters([
                'user_id' => $user->id,
                'status' => [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND],
            ]);
            // Kiểm tra người có đang mượn sách quá hạn hay không
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $to_date= Carbon::parse($request->input('to_date'));
            $to_date->setTime(23, 59, 59);
            $check_overdue = $this->repository->existsByFilters([
                'user_id' => $user->id,
                'status' =>BorrowerEnums::STATUS_OVERDUE,
                'now' => $now
            ]);
            if ($check_overdue) {
                throw new \ErrorException(
                    'Bạn đang có sách quá hạn nên không thể mượn được nữa!',
                    Response::HTTP_NOT_FOUND
                );
            }
            // Kiểm tra bạn có đang mượn tối đa 3 cuốn sách không
            if ($borrowedCount < config('constants.USER_BORROW_COUNT')) {
                // Kiểm tra số lượng sách trong kho
                $bookQuantity = $request->book_quantity; // Số lượng sách có sẵn
                $borrowedCountBook = $this->repository->countByFilters([
                    'book_id' => $bookId,
                    'status' => [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND],
                ]);
                // Kiểm tra số sách trong kho trước khi mượn
                if($bookQuantity > $borrowedCountBook){ 
                    // Lấy dữ liệu để gửi email cho Quản trị viên, Người dùng
                    $mailData = [
                        'email' => $user->email,
                        'user_name' => $user->name,
                        'book_id' => $bookId,
                        'book_name' => $request->book_name,
                        'author' => $request->author,
                        'to_date' => $to_date->format('d-m-Y'),
                        'emailAdmin' => $emailAdmin,
                        ];           
                        $allowed_renewal ='';
                        $extended_date = Carbon::parse($request->input('to_date'));
                        $extended_date->setTime(23, 59, 59);
                        if ($request->has('auto_renew')) {
                            $extended_date->addDays(15);
                            $allowed_renewal = BorrowerEnums::RENEWAL_ONE;
                            dispatch(new SendMailBorrowerAutoRenew($mailData));
                            dispatch(new SendMailBorrowerAutoRenewAdmin($mailData));
                        }else{
                            $allowed_renewal = BorrowerEnums::RENEWAL_NONE;
                        }
                        // Kiểm tra số lượng khi nhập vào, bắt buộc chỉ được mượn 1 cuốn
                        $check_quantity = $request->input('quantity');
                        if ($check_quantity != config('constants.QUANTITY_BORROW_BOOK')) {
                            throw new \ErrorException(
                                'Không thể mượn quá 1 cuốn sách 1 lần!',
                                Response::HTTP_NOT_FOUND
                            );   
                        };
                        // Kiểm tra ngày trả không được để trống, không được để ngày quá khứ
                        $check_to_date = $request->input('to_date');
                        if (is_null($check_to_date)) {
                            throw new \ErrorException(
                                'Ngày trả không được để trống!',
                                Response::HTTP_NOT_FOUND
                            );
                        };
                        $this->repository->create([
                            'user_id' => $user->id,
                            'book_id' => $bookId,
                            'from_date' =>$now,
                            'note' => $request->input('note'),
                            'to_date' => $to_date,
                            'allowed_renewal' => $allowed_renewal,
                            'auto_renew' => $request->has('auto_renew'),
                            'extended_date' => $extended_date,                         
                        ]);

                        // Insert in to Notification table
                        $users = $this->userRepository->all();
                        $admins = $this->adminRepository->all();
                        $data = [
                            'title' => 'Mượn sách',
                            'content' => $request['contentNotify'],
                            'bookId' => $bookId,
                            'bookImage' => $request['bookImage'],
                        ];
                        Notification::send($users, new BookNotifications($data));
                        Notification::send($admins, new BookNotifications($data));
                        
                        // Jobs queue send email 
                        dispatch(new SendMailBorrower($mailData));
                        dispatch(new SendMailBorrowerAdmin($mailData));
                } else {
                    throw new \ErrorException(
                    'Sách trong thư viện đã hết, xin hãy quay lại sau!',
                    Response::HTTP_NOT_FOUND
                );
                }
            } else {
                throw new \ErrorException(
                    'Bạn đã mượn tới số lượng tối đa!',
                    Response::HTTP_NOT_FOUND
                );
            }
        }
    }
    
    public function countBetweenDayRange($startDate, $endDate, $column)
    {
        return $this->repository->getColumnByFieldBetweenRange($column , 'from_date',[$startDate,  $endDate]);
    }

    public function getStatistic($startDate, $endDate)
    {
        return $this->repository->getBooksByBorrowerCountBetweenDates($startDate, $endDate);
    }

    public function index($request)
    {
        return $this->repository->paginateByFilters(
            ['categories' => @$request['categories'], 'searchAdmin' => @$request['searchAdmin'], 'status' => @$request['status']],
            config('constants.DEFAULT_PAGINATION'),
            ['categories','book', 'users'],
            ['from_date' => 'desc', 'updated_at' => 'desc', 'to_date' => 'desc']
        );
    }    

    public function getOverDue(){
        return $this->repository->getAllByFilters(
            ['overdue' => true, 'status' => [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND, BorrowerEnums::STATUS_OVERDUE]],
            ['users', 'book']
        );
    }

    public function updateMultipleStatus($updateIds, $status){
        return$this->repository
            ->where('status', '<>', $status)
            ->whereIn('id', $updateIds)->update(['status' => $status]);
    }

    public function countTotalBook($bookId, $status)
    {
        return $this->repository->countByFilters(
            ['book_id' => $bookId, 'status' => $status]
        );
    }
    
    public function countNewBorrower($startDate, $endDate)
    {
        return $this->repository->countByFilters(
            ['between_column' => 'from_date', 'between_date' => [$startDate, $endDate]]
        );
    }
}
