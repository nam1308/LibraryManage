<?php

namespace App\Services\Api;

use App\Enums\BorrowerEnums;
use App\Enums\BookEnums;
use App\Jobs\User\ProcessSendMailBookReturn;
use App\Services\Contracts\BookServiceInterface;
use App\Traits\FileTrait;
use App\Repositories\Contracts\BookRepository;
use App\Repositories\Contracts\BorrowerRepository;
use App\Repositories\Contracts\NotificationRepository;
use App\Imports\BooksImport;
use App\Notifications\BookNotifications;
use App\Repositories\Contracts\AdminRepository;
use App\Repositories\Contracts\ReflectionRepository;
use App\Repositories\Contracts\UserBookRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Contracts\UserRepository;

class BookService implements BookServiceInterface
{
    use FileTrait;

    /**
     * @var BookRepository
     */
    protected $repository;
    protected $borrowerRepository;
    protected $notificationRepository;
    protected $reflectionRepository;
    protected $userBookRepository;
    protected $userRepository;
    protected $adminRepository;

    public function __construct(
        BookRepository $repository,
        BorrowerRepository $borrowerRepository,
        NotificationRepository $notificationRepository,
        ReflectionRepository $reflectionRepository,
        UserBookRepository $userBookRepository,
        UserRepository $userRepository,
        AdminRepository $adminRepository
    )
    {
        $this->repository = $repository;
        $this->borrowerRepository = $borrowerRepository;
        $this->notificationRepository = $notificationRepository;
        $this->reflectionRepository = $reflectionRepository;
        $this->userBookRepository = $userBookRepository;
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
    }

    public function show($id)
    {
        $filters = [
            'book_id' => $id,
            'borrower_count' => true,
        ];
        $book = $this->repository->firstByFilters(
            $filters,
            ['categories:id,name,status'],
        );
        if (!$book) {
            abort(404);
        }
        return $book;
    }

    public function index($request)
    {
        return $this->repository->paginateByFilters(
            ['categories' => @$request['categories'], 'search' => @$request['search'], 'deleted_at' => true, 'borrower_count' => true],
            config('constants.DEFAULT_PAGINATION'),
            ['categories:id,name'],
            ['updated_at' => 'desc', 'book_cd' => 'desc']
        );
    }

    public function homeUser($request)
    {
        $filters = [
            'search' => @$request['search'],
            'categories' => @$request['categories'],
            'borrower_count' => true,
        ];
        return $this->repository->paginateByFilters(    
            $filters,
            config('constants.DEFAULT_PAGINATION_USER'),
            ['categories:id,category_cd,name,slug,status,note', 'borrowers:id,book_id'],
            ['created_at' => 'desc']);
    }

    public function destroy($id)
    {
        $book = $this->repository->firstById($id);
        if (empty($book))
            return ['success' => false, 'message' => 'Không tìm thấy sách!'];

        if ($this->borrowerRepository->countTheNumberBook($id) != BookEnums::ZERO)
            return ['success' => false, 'message' => 'Sách đang được mượn hoặc gia hạn!'];

        $book->delete();
        return ['success' => true, 'message' => 'Xóa sách thành công!'];
    }

    public function destroyGiver($id)
    {
        try {
            $userBooks = $this->userBookRepository->firstById($id);
            if(empty($userBooks)) {
                return ['success' => false, 'message' => 'Không tìm thấy người tặng!'];
            }

            $bookBorrowedCount = $this->borrowerRepository
                ->where('book_id', $userBooks->book_id)
                ->whereIn('status', [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND])
                ->count();
            $userBooksCount = $this->userBookRepository
                ->where('book_id', $userBooks->book_id)
                ->count();
            $book = $this->repository->firstById($userBooks->book_id);

            if ($book->quantity - $userBooks->quantity < $bookBorrowedCount) {
                return ['success' => false, 'message' => 'Số sách cho mượn vượt quá số sách còn lại!'];
            } elseif ($userBooksCount == BookEnums::ONE) {
                return ['success' => false, 'message' => 'Không được xóa hết người tặng!'];
            } else {
                $book->quantity = $book->quantity - $userBooks->quantity;
                $book->save();
                $userBooks->delete();
                return ['success' => true, 'message' => 'Xóa người tặng thành công!'];
            }
        }
        catch (\Exception $e) {
            return ['success' => false, 'message' => 'Xoá người tặng thất bại!'];
        }
    }

    public function getAllBook($request)
    {
        $books = $this->repository;
        if ($request == 'isDeleted') {
            $books = $this->repository->withTrashed();
        }
        return $books->pluck('name', 'book_cd');
    }

    public function checkBookBorrowing($bookId)
    {
        if (Auth::check()) {
            $userID = auth()->user()->id;
            $checkBookBorrowing = $this->borrowerRepository->existsByFilters(
                [
                    'user_id' => $userID,
                    'book_id' => $bookId,
                    'notStatus' => BorrowerEnums::STATUS_INACTIVE,
                ],
            );
            return $checkBookBorrowing;
        }
    }

    public function totalBookBorrow($bookId)
    {
        $totalBookBorrow = $this->borrowerRepository->countByFilters(
            ['book_id' => $bookId]
        );
        return $totalBookBorrow;
    }

    public function store($request)
    {
        $book = $this->repository->where(['name' => $request['name'], 'book_cd' => $request['book_cd']])->first();

        if (!empty($book)) {
            $book->update([
                'quantity' => $request['quantity'] + $book->quantity,
                'author' => $request['author'],
                'description' => $request['description'],
            ]);
        } else {
            $uploadFile = $this->upload($request['image'], 'books');
            $request['image'] = $uploadFile;
            $book = $this->repository->create($request);
        }
        $book->users()->attach([$request['user_id'] => ['quantity' => $request['quantity']]]);
        $book->categories()->sync($request['categories']);
        return $book;
    }

    public function getBookFromBorrower($id)
    {
        if (auth()->check()) {
            return $this->borrowerRepository->firstByFilters(
                [
                    'user_id' => auth()->user()->id, 
                    'book_id' => $id, 
                    'notStatus' => BorrowerEnums::STATUS_INACTIVE
                ]
            );
        }
    }

    public function updateBorrowerRenewal($id, $request)
    {
        $borrower = $this->borrowerRepository->find($id);

        if (empty($borrower)) {
            return null;
        }

        $allowedRenewal = $borrower->allowed_renewal;
        $status = $this->getBorrowerStatus($borrower->to_date);
        switch ($allowedRenewal) {
            case BorrowerEnums::RENEWAL_NONE:
                $borrowerUpdate = [
                    'allowed_renewal' => BorrowerEnums::RENEWAL_ONE,
                    'extended_date' => $request['due_date'],
                    'note' => $request['note'],
                ];
                break;
            case BorrowerEnums::RENEWAL_ONE:
                $borrowerUpdate = [
                    'allowed_renewal' => BorrowerEnums::RENEWAL_TWO,
                    'extended_date' => $request['due_date'],
                    'note' => $request['note'],
                ];
                break;
            default:
                return null;
        }

        $borrowerUpdate['status'] = $status;
        $this->borrowerRepository->update($borrowerUpdate, $id);

        // Insert in to Notification table
        $users = $this->userRepository->all();
        $admins = $this->adminRepository->all();
        $data = [
            'title' => 'Gia hạn sách',
            'content' => $request['contentNotify'],
            'bookId' => $request['bookId'],
            'bookImage' => $request['bookImage'],
        ];
        Notification::send($users, new BookNotifications($data));
        Notification::send($admins, new BookNotifications($data));

        return $borrowerUpdate;
    }

    public function getBorrowerStatus($toDate)
    {
        $toDate = Carbon::parse($toDate);
        $now = Carbon::now();

        return ($toDate->isSameDay($now)) ? BorrowerEnums::STATUS_EXTEND : (($toDate->greaterThan($now)) 
            ? BorrowerEnums::STATUS_ACTIVE : BorrowerEnums::STATUS_EXTEND);
    }

    public function updateBorrowerStatus($borrowerIds)
    {
        $this->borrowerRepository->whereIn('id', $borrowerIds)
            ->update([
                'status' => DB::raw("CASE WHEN to_date = CURDATE() THEN '".BorrowerEnums::STATUS_EXTEND."' 
                                        WHEN to_date > CURDATE() THEN '".BorrowerEnums::STATUS_ACTIVE."'
                                        ELSE '".BorrowerEnums::STATUS_EXTEND."' END")
            ]);
    
        return $this->borrowerRepository->whereIn('id', $borrowerIds)->get();
    }
    
    public function getBorrowersForUpdateStatus()
    {
        return $this->borrowerRepository->where('allowed_renewal', '!=', BorrowerEnums::RENEWAL_NONE)
            ->where('status', '=', BorrowerEnums::STATUS_ACTIVE)
            ->get();
    }

    public function bookReturnHandler($bookId, $request, $emailAdmin)
    {

        $mailData = [
            'tittle' => 'Thông báo trả sách',
            'contentNotify' => $request['contentNotify'],
            'email' => auth()->user()->email,
            'emailAdmin' => $emailAdmin
        ];
        dispatch(new ProcessSendMailBookReturn($mailData));

        // Insert in to Notification table
        $users = $this->userRepository->all();
        $admins = $this->adminRepository->all();
        $data = [
            'title' => 'Trả sách',
            'content' => $request['contentNotify'],
            'bookId' => $bookId,
            'bookImage' => $request['bookImage'],
        ];
        Notification::send($users, new BookNotifications($data));
        Notification::send($admins, new BookNotifications($data));

        // Update column STATUS in BORROWER table
        $this->borrowerRepository->updateByFilters([
            ['user_id', '=', auth()->user()->id],
            ['book_id', '=', $bookId],
            ['status', '!=', BorrowerEnums::STATUS_INACTIVE],
        ],
        [
            'status' => BorrowerEnums::STATUS_INACTIVE,
            'to_date' => Carbon::now(),
        ]);
    }

    public function details($id)
    {
        $book = $this->repository->withTrashed()->find($id);
        $users = (!$book) ? [] : $book->users()
            ->select('users.name', 'user_book.quantity', 'user_book.created_at', 'user_book.id as userBook', 'user_book.updated_at as userBookUpdate')
            ->orderBy('user_book.updated_at', 'desc')
            ->orderBy('user_book.user_id', 'desc')
            ->whereNull('user_book.deleted_at')
            ->paginate(config('constants.DEFAULT_PAGINATION'));
        return [
            'book' => $book,
            'users' => $users
        ];
    }

    public function fetchData($request)
    {
        return $this->repository->with('categories')->where(['name' => $request['name'], 'book_cd' => $request['book_cd']])->first();
    }

    public function countBook()
    {
        return $this->repository->count();
    }

    public function showEditBook($id)
    {
        return $this->repository->firstById($id, ['categories', 'users']);
    }

    public function update($request)
    {
        $book = $this->repository->find($request['id']);
        if (empty($book)) return null;
        $dataUpdate = [];

        if (!empty($request['image'])) {
            $uploadFile = $this->upload($request['image'], 'books');
            $dataUpdate['image'] = $uploadFile;
        }

        if (!empty($request['isDetail'])) {
            if (!empty($request['user-book-id'])) {
                $pivotQuantity = $book->users()->wherePivot('id', $request['user-book-id'])->value('quantity');
                $book->users()->wherePivot('id', $request['user-book-id'])
                    ->update(['user_id' => $request['user_id'],'quantity' => $request['quantity']]);
                $dataUpdate['quantity'] = $book->quantity - $pivotQuantity + $request['quantity'];
            }
            else {
                $book->users()->attach([$request['user_id'] => ['quantity' => $request['quantity']]]);
                $dataUpdate['quantity'] = $book->quantity + $request['quantity'];
            }

        } else {
            $dataUpdate['book_cd'] = $request['book_cd'];
            $dataUpdate['name'] = $request['name'];
            $dataUpdate['author'] = $request['author'];
            $dataUpdate['description'] = $request['description'];
            $cateBook = $book->categories()->sync($request['categories']);
            if (array_filter($cateBook)) {
                $book->touch();
            }
        }
        $book->update($dataUpdate);
        return $book;
    }

    public function importFile($request)
    {
        try {
            Excel::import(new BooksImport, $request);
            return ['success' => true];
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return ['success' => false, 'errors' => $e->failures()];
        }
    }

    public function getStatistic($filters, $relation = [], $column = ['*'])
    {
        return $this->repository->getAllByFilters(
            ['field_between' => 'created_at', 'range' => [$filters['start'], $filters['end']]],
            $relation,
            [],
            ['id']
        );
    }

    public function getTopStatistic($startDate, $endDate, $limit)
    {
        return $this->repository->getTopBooksByBorrowerCountBetweenDates($startDate, $endDate, $limit);
    }
    
    public function createReflectionBook($request){
        $userID = auth()->user()->id;
        $reflection = $this->reflectionRepository->create([
            'user_id' => $userID,
            'book_id' => $request['book_cd'],
            'content' => $request['note'],
            'vote' => $request['rate'],
            'is_hidden' => isset($request['check']) ? config('constants.USER_NAME_HIDDEN_TRUE') : config('constants.USER_NAME_HIDDEN_FALSE')
        ]);
        return $reflection;
    }
     
    public function updateReflectionBook($request, $reflection_id){
        $userID = auth()->user()->id;
        $reflection = $this->reflectionRepository->update([
            'user_id' => $userID,
            'book_id' => $request['book_id'],
            'content' => $request['note'],
            'vote' => $request['rate'],
            'is_hidden' => isset($request['check']) ? config('constants.USER_NAME_HIDDEN_TRUE') : config('constants.USER_NAME_HIDDEN_FALSE') 
            ], $reflection_id);
        return $reflection;
    }

    public function findReflectionBook($id_reflection){
        return $this->reflectionRepository->find($id_reflection);
    }
    public function checkTotalBook($request)
    {
            $book = $this->repository->find($request['id']);
            if (!$book) return null;
            $pivotQuantity = $book->users()->wherePivot('id', $request['user-book-id'])->value('quantity');
            $totalBook = $book->quantity - $pivotQuantity + $request['quantity'];
            $borrowTotal = $this->borrowerRepository->countTheNumberBook($book->id);
            $statusQuantity = ($totalBook < $borrowTotal) ? true : false;
            return $statusQuantity;
    }

    public function bookCreateNotification($book)
    {
        $users = $this->userRepository->all();
        $data = [
            'title' => 'Thêm mới sách',
            'content' => 'Cuốn sách ' . $book->name . ' vừa được admin thêm vào hệ thống',
            'bookId' => $book->id,
            'bookImage' => $book->image,
        ];
        Notification::send($users, new BookNotifications($data));
    }
}
