<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserEnums;
use App\Enums\HomeEnums;
use App\Services\Contracts\BorrowerServiceInterface;
use App\Http\Controllers\Controller;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
        /**
     * Parameter
     *
     * @var BorrowerServiceInterface
     * @var BookServiceInterface
     * @var UserServiceInterface
     */
    protected $BorrowerService;
    protected $BookService;
    protected $UserService;

    /**
     * CategoryServiceInterface constructor.
     *
     * @param BorrowerServiceInterface $CategoryServiceInterface
     */
    public function __construct(
        BorrowerServiceInterface $BorrowerService,
        BookServiceInterface $BookService,
        UserServiceInterface $UserService
    ){
        $this->BorrowerService = $BorrowerService;
        $this->BookService = $BookService;
        $this->UserService = $UserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        $startDateOld = Carbon::yesterday()->startOfDay();
        $endDateOld = Carbon::yesterday()->endOfDay();
        $filterType = HomeEnums::FILTER_DATE;

        if(isset($data['filter_type'])){
            if($data['filter_type'] == HomeEnums::FILTER_MONTH){
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                $startDateOld = now()->subMonth()->startOfMonth();
                $endDateOld = now()->subMonth()->endOfMonth();
                $filterType = HomeEnums::FILTER_MONTH;
            }else if($data['filter_type'] == HomeEnums::FILTER_QUARTER){
                $startDate = now()->startOfQuarter();
                $endDate = now()->endOfQuarter();
                $startDateOld = now()->subQuarter()->startOfQuarter();
                $endDateOld = now()->subQuarter()->endOfQuarter();
                $filterType = HomeEnums::FILTER_QUARTER;
            }
        }

        $newBorrowerStatistic = $this->BorrowerService->countNewBorrower($startDate, $endDate);
        $newBorrowerStatisticOld = $this->BorrowerService->countNewBorrower($startDateOld, $endDateOld);

        $borrowerStatistic = $this->BorrowerService->countBetweenDayRange($startDate, $endDate, 'status')->toArray();
        $borrowerStatisticOld = $this->BorrowerService->countBetweenDayRange($startDateOld, $endDateOld, 'status')->toArray();

        $booksStatistic = count($this->BookService->getStatistic(['start' => $startDate, 'end' => $endDate]));
        $booksStatisticOld = count($this->BookService->getStatistic(['start' => $startDateOld, 'end' => $endDateOld]));
        
        $usersStatistic = count($this->UserService->getStatistic(['start' => $startDate, 'end' => $endDate, 'status' => UserEnums::STATUS_ACTIVE]));
        $usersStatisticOld = count($this->UserService->getStatistic(['start' => $startDateOld, 'end' => $endDateOld, 'status' => UserEnums::STATUS_ACTIVE]));

        $topBooks = $this->BookService->getTopStatistic($startDate, $endDate, config('constants.TOP_STATISTIC_DEFAULT_LIMIT'))->toArray();
        $topUsers = $this->UserService->getTopStatistic($startDate, $endDate, config('constants.TOP_STATISTIC_DEFAULT_LIMIT'))->toArray();

        return view('admin.home.index', [
            'filterType' => $filterType,
            'newBorrowerStatistic' => $newBorrowerStatistic,
            'newBorrowerStatisticOld' => $newBorrowerStatisticOld,
            'borrowerStatistic' => $borrowerStatistic,
            'borrowerStatisticOld' => $borrowerStatisticOld,
            'booksStatistic' => $booksStatistic,
            'booksStatisticOld' => $booksStatisticOld,
            'usersStatistic' => $usersStatistic,
            'usersStatisticOld' => $usersStatisticOld,
            'topBooks' => $topBooks,
            'topUsers' => $topUsers,
        ]);
    }
}
