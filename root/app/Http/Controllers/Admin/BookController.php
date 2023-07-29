<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookEnums;
use App\Enums\CategoryEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Http\Request;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Contracts\ReflectionServiceInterface;
use App\Services\Contracts\BorrowerServiceInterface;
use App\Http\Requests\ImportBookRequest;
use App\Enums\BorrowerEnums;

class BookController extends Controller
{
    /**
     * Parameter
     *
     * @var BookServiceInterface
     */
    protected $userService;
    protected $bookService;
    protected $categoryService;
    protected $notificationService;
    protected $reflectionService;
    protected  $borrowerService;

    /**
     * UserServiceInterface constructor.
     *
     * @param BookServiceInterface $bookService
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(
        BookServiceInterface         $bookService,
        UserServiceInterface         $userService,
        CategoryServiceInterface     $categoryService,
        NotificationServiceInterface $notificationService,
        ReflectionServiceInterface   $reflectionService,
        BorrowerServiceInterface     $borrowerService
    )
    {
        $this->reflectionService = $reflectionService;
        $this->userService = $userService;
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->notificationService = $notificationService;
        $this->borrowerService = $borrowerService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $books = $this->bookService->index($data)->appends($data);
        $listBooks = $this->bookService->getAllBook(null);
        $allBooks = $this->bookService->getAllBook('isDeleted');
        $userActives = $this->userService->getUser();
        $categories = $this->categoryService->getCategory();
        $cateActives = $this->categoryService->categoryActive();
        if (!empty($data)) {
            if($books->lastPage() < $books->currentPage()) {
                Paginator::currentPageResolver(function () {
                    return BookEnums::ONE;
                });
                $books = $this->bookService->index($data)->appends($data);
            }
            return view('admin.books.table_book', [
                'books' => $books,
                'countBook' => $books->total(),
            ]);
        }
        return view('admin.books.index', [
            'allBooks' => $allBooks,
            'books' => $books,
            'listBooks' => $listBooks,
            'categories' => $categories,
            'userActives' => $userActives,
            'cateActives' => $cateActives,
            'countBook' => $books->total(),
        ]);
    }

    public function create(StoreBookRequest $request)
    {
        $data = $request->all();
        $book = $this->bookService->store($data);

        if (!$book) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thêm mới sách thất bại!']);
        }

        if ($book->wasRecentlyCreated) {
            $this->bookService->bookCreateNotification($book);
        }

        return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Thêm mới sách thành công!']);
    }

    public function details($id)
    {
        $data = $this->bookService->details($id);
        $book = $data['book'];

        if (empty($book)) {
            return abort(404);
        }
        // Get category
        $cateToShow = [];
        $maxCateToShow = config('constants.DEFAULT_CATEGORIES_IN_BOOK_DETAILS');
        foreach ($book->categories as $key => $value) {
            $cateToShow[] = $value->name;
            if ($key == $maxCateToShow - 1) {
                break;
            }
        }
        $cateToShow = implode(', ', $cateToShow);
        if (count($book->categories) > $maxCateToShow) {
            $cateToShow .= '...';
        }

        $users = $data['users'];
        $isDetail = BookEnums::IS_DETAIL;
        $isSoftDeleted = !$book->trashed();;
        $listBooks = $this->bookService->getAllBook(null);
        $userActives = $this->userService->getUser();
        $cateActives = $this->categoryService->categoryActive();
        $borrowTotal = $this->borrowerService->countTotalBook($book->id,[BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND]);
        $reflectionTotal = $this->reflectionService->totalBookReflection($book->id);
        return view('admin.books.details', compact(
            'book', 'borrowTotal', 'id', 'users','cateToShow', 'isSoftDeleted', 'listBooks', 'cateActives', 'userActives', 'isDetail', 'reflectionTotal'
        ));
    }

    public function destroy(Request $request)
    {
        try {
            $book = $this->bookService->destroy($request->id);
            if ($book['success']) {
                return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Xoá sách thành công!']);
            } else {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $book['message']]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $e->getMessage()]);
        }
    }

    public function destroyGiver(Request $request)
    {
        try {
            $response = $this->bookService->destroyGiver($request->id);

            if ($response['success']) {
                return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Xoá người tặng thành công!']);
            } else {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $response['message']]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $e->getMessage()]);
        }
    }


    public function fetchData(Request $request)
    {
        $book = $this->bookService->fetchData($request);
        if (!empty($book)) {
            $data = [
                'found' => true,
                'book' => $book
            ];
        } else {
            $data = [
                'found' => false,
            ];
        }
        return response()->json($data);
    }

    public function showEditModal(Request $request, $id)
    {
        $userId = $request->input('userId');

        if (empty($id)) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Lỗi!']);
        }

        $book = $this->bookService->showEditBook($id);
        $userBook = $book->users()->select('users.name', 'user_book.quantity', 'user_book.user_id')->where('user_book.id', $userId)->first();
        $data = [
            'book' => $book,
            'userBook' => $userBook
        ];
        return response()->json($data);
    }

    public function update(StoreBookRequest $request)
    {
        try {
            if (!empty($request['user-book-id'])) {
                $statusQuantity = $this->bookService->checkTotalBook($request);
                if ($statusQuantity) {
                    throw new \Exception('Tổng số sách phải lớn hơn sách mượn');
                }
            }

            $book = $this->bookService->update($request->all());

            if (empty($book)) {
                throw new \Exception('Chỉnh sửa thất bại. Vui lòng kiểm tra lại!');
            }

            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Chỉnh sửa thành công!']);
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $e->getMessage()]);
        }
    }

    public function importCsv(ImportBookRequest $request)
    {
        try {
            $importResult = $this->bookService->importFile($request->fileCsv);

            if ($importResult['success']) {
                return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Import File thành công!']);
            } else {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $importResult['errors']]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => $e->getMessage()]);
        }
    }
}