<?php

namespace App\Http\Controllers\User;

use App\Enums\BorrowerEnums;
use App\Enums\CategoryEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReflectionRequest;
use App\Services\Contracts\AdminServiceInterface;
use App\Jobs\User\ProcessSendMailRenewalBook;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\ReflectionServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    protected $bookService;
    protected $reflectionService;
    protected $adminService;

    public function __construct(
        ReflectionServiceInterface $reflectionService,
        BookServiceInterface $bookService,
        AdminServiceInterface $adminService
    ) {
        $this->bookService = $bookService;
        $this->reflectionService = $reflectionService;
        $this->adminService = $adminService;
    }
    
    public function show(Request $request,$id)
    {
        $data = @$request->all();
        $filter = [
            'vote' => @$data['vote'],
            'filter_book_id' => $id
        ];
        // Get data book
        $book = $this->bookService->show($id);

        // Get category
        $cateToShow = [];
        $countCateActive = 0;
        foreach ($book->categories as $value) {
            if ($value->status == CategoryEnums::STATUS_ACTIVE) {
                $countCateActive++;
                array_push($cateToShow, $value->name);
            }
        }
        if ($countCateActive > config('constants.DEFAULT_CATEGORIES_IN_BOOK_DETAILS')) {
            $cateToShow = array_slice($cateToShow, 0, intval(config('constants.DEFAULT_CATEGORIES_IN_BOOK_DETAILS')));
            $cateToShow = implode(", ",$cateToShow);
            $addToEnd = "...";
            $cateToShow.= $addToEnd;
        }
        else {
            $cateToShow = implode(", ",$cateToShow);
            $addToEnd = ".";
            $cateToShow.= $addToEnd;
        }

        // Count book borrowed
        $totalBorrow = $this->bookService->totalBookBorrow($id);

        // Check new book
        $checkNewBook = Carbon::now()->diff($book->created_at)->days;

        // Get reflections
        $reflections = $this->reflectionService->show($filter);

        // AVG star of the reflections
        $avgStar = $this->reflectionService->getAverageStarByBookId($book->id);

        // Get borrower of user per book
        $getBookFromBorrower = $this->bookService->getBookFromBorrower($id);

        // Check book borrowing
        $checkBookBorrowing = !empty($getBookFromBorrower) ? true : false;

        // Total reflections
        $reflectionTotal = $this->reflectionService->totalBookReflection($book->id);

        if ((@$data['vote'] || (@$request->vote)==='all')) {        
            return view('users.books.show_reflection', [
                'reflections' => $reflections,
                'vote' => @$data['vote'],
            ]);
        }
        
        return view('users.books.details',[
            'book' => $book,
            'checkBookBorrowing' => $checkBookBorrowing,
            'checkNewBook' => $checkNewBook,
            'totalBorrow' => $totalBorrow,
            'reflections' => $reflections,
            'reflectionTotal' => $reflectionTotal,
            'avgStar' => $avgStar,
            'getBookFromBorrower' => $getBookFromBorrower,
            'cateToShow' => $cateToShow,
        ]);
    }

    public function renewalBook(Request $request, $id)
    {
        if ($request->status == 1) {
            return response()->json([
                'status'  => 404,
                'title'   => 'Lỗi',
                'message' => 'Sách đang quá hạn hoặc không được mượn!',
            ]);
        }
        // Kiểm tra số lượng khi nhập vào, bắt buộc chỉ được mượn 1 cuốn
        $check_quantity = $request->input('quantity');
        if ($check_quantity != config('constants.QUANTITY_RENEWAL_BOOK')) {
            return response()->json([
                'status'  => 404,
                'title'   => 'Lỗi',
                'message' => 'Chỉ được gia hạn 1 cuốn sách 1 lần!',
            ]);
        };
        $emailAdmin=$this->adminService->getEmail();
        $data=$request->all();
        $book = $this->bookService->show($id);
        $getBookFromBorrower = $this->bookService->getBookFromBorrower($id);
        $toDate = Carbon::parse($getBookFromBorrower->to_date); // chuyển đổi sang đối tượng Carbon
        $nextDayFromToDate = $toDate->addDay();
        $extendedDate = Carbon::parse($getBookFromBorrower->extended_date);
        $nextDayFromExtendedDate = $extendedDate->addDay();
        $now = Carbon::now();
        $borrower_id=$getBookFromBorrower->id;
        $mailData=[
            'email' => auth()->user()->email,
            'user_name' => auth()->user()->name,
            'extended_date' => $data['due_date'],
            'contentNotify' => $data['contentNotify'],
            'book_name' => $data['book_name'],
            'book_author' => $data['book_author'],
            'emailAdmin' => $emailAdmin,
        ];

        $daysUntilDue = ($getBookFromBorrower->allowed_renewal == 0) ? $now->diffInDays($nextDayFromToDate) : $now->diffInDays($nextDayFromExtendedDate);

        if($data['allowed_renewal'] === BorrowerEnums::RENEWAL_TWO){
            return response()->json([
                'status'  => 404,
                'title'   => 'Lỗi',
                'message' => 'Bạn không thể gia hạn thêm vì bạn đã gia hạn 2 lần!',
            ]);
        }
        if ($daysUntilDue <= config('constants.DEFAULT_TO_DATE')) { // nếu còn 10 ngày trở lại để đến hạn
            try {
                DB::beginTransaction();
                $this->bookService->updateBorrowerRenewal($borrower_id, $request);
                dispatch(new ProcessSendMailRenewalBook($mailData));
                DB::commit();
                return response()->json([
                    'status'  => 200,
                    'title'   => 'Thông báo',
                    'message' => auth()->user()->name . ' gia hạn thành công cuốn sách ' . $book->name . ' của tác giả ' . $book->author,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status'  => 404,
                    'title'   => 'Lỗi',
                    'message' => 'Có lỗi xảy ra khi gia hạn sách!',
                ]);
            }
        } else {
            if($now->diffInDays(($getBookFromBorrower->allowed_renewal == 0) ? $toDate : $extendedDate, false) > 0){
                try {
                    DB::beginTransaction();
                    $this->bookService->updateBorrowerRenewal($borrower_id, $request);
                    dispatch(new ProcessSendMailRenewalBook($mailData));
                    DB::commit();
                    return response()->json([
                        'status'  => 200,
                        'title'   => 'Thông báo',
                        'message' => auth()->user()->name . ' gia hạn thành công cuốn sách ' . $book->name . ' của tác giả ' . $book->author,
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 404,
                        'title'   => 'Lỗi',
                        'message' => 'Có lỗi xảy ra khi gia hạn sách!',
                    ]);
                }
            }
            else{
                return response()->json([   
                    'status'  => 404,
                    'title'   => 'Lỗi',
                    'message' => 'Bạn không thể gia hạn vì đã quá thời hạn!',
                ]);   
            }
        }
    }

    public function returnHandler(Request $request, $id)
    {
        $emailAdmin=$this->adminService->getEmail();
        $this->bookService->bookReturnHandler($id, $request->all(),$emailAdmin);
        return response()->json([
            'status'  => 200,
            'title'   => 'Thông báo',
            'message' => 'Trả sách thành công.',
        ]);
    }
    public function reflectionBook(ReflectionRequest $request){
        try {
            DB::beginTransaction(); // bắt đầu transaction
            $this->bookService->createReflectionBook($request->all());
            DB::commit(); // commit transaction
            return response()->json([
                'status' => 'success',
                'title' => 'Thông báo',
                'message' => 'Cập nhật đánh giá thành công'
            ]);
            } catch (\Exception $e) {
            DB::rollback(); // rollback transaction khi có lỗi
            return response()->json([
                'status' => 'error',
                'title' => 'Lỗi',
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật đánh giá sách'
            ]);
            }
    }

    public function updateReflection(ReflectionRequest $request, $reflection_id){
        try {
            DB::beginTransaction(); // bắt đầu transaction
            $this->bookService->updateReflectionBook($request->all(), $reflection_id);
            DB::commit(); // commit transaction
            return response()->json([
                'status' => 'success',
                'title' => 'Thông báo',
                'message' => 'Chỉnh sửa đánh giá thành công'
            ]);
            } catch (\Exception $e) {
            DB::rollback(); // rollback transaction khi có lỗi
            return response()->json([
                'status' => 'error',
                'title' => 'Lỗi',
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật đánh giá sách'
            ]);
            }
    }

    public function findReflection($id_reflection) {
        return $this->bookService->findReflectionBook($id_reflection);
    }
}
