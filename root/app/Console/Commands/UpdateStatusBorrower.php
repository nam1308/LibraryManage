<?php

namespace App\Console\Commands;

use App\Enums\BorrowerEnums;
use App\Jobs\Admin\SendBorrowerStatusChangeMail;
use Illuminate\Console\Command;
use App\Services\Api\BookService;
use App\Services\Contracts\BorrowerServiceInterface;
use Carbon\Carbon;

class UpdateStatusBorrower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_status_borrowers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status Borrowers';

    /**
     * The BookService instance.
     *
     * @var \App\Services\Api\BookService
     */
    protected $bookService;

    /**
     * The borrowerService instance.
     *
     * @var App\Services\Contracts\BorrowerServiceInterface
     */
    protected $borrowerService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\Api\BookService  $bookService
     * @param  App\Services\Contracts\BorrowerServiceInterface
     * @return void
     */
    public function __construct(BookService $bookService, BorrowerServiceInterface $borrowerService)
    {
        parent::__construct();
        $this->bookService = $bookService;
        $this->borrowerService = $borrowerService;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $borrowers = $this->bookService->getBorrowersForUpdateStatus();
        $borrowerIds = $borrowers->pluck('id')->toArray();
        $this->bookService->updateBorrowerStatus($borrowerIds);

        $overdueBorrowers = $this->borrowerService->getOverDue();
        $arrId = [];
        $dataMail = [];
        foreach ($overdueBorrowers as $borrowers) {
            $overdueDate = $borrowers->to_date;
            if (!empty($borrowers->extended_date)) {
                $overdueDate = $borrowers->extended_date;
            }
            $overdueDate = Carbon::create($overdueDate);
            if ($borrowers->status != BorrowerEnums::STATUS_OVERDUE) {
                $arrId[] = $borrowers->id;
            }
            $overdueBy = $overdueDate->startOfDay()->diffInDays(now()->startOfDay());
            if (in_array($overdueBy, [BorrowerEnums::OVERDUE_WARNING_DATE_FIRST, BorrowerEnums::OVERDUE_WARNING_DATE_SECOND, BorrowerEnums::OVERDUE_WARNING_DATE_THIRD])) {
                $dataMail[] = [
                    'id' => $borrowers->id,
                    'email' => $borrowers->users->email,
                    'name' => $borrowers->book->name,
                    'author' => $borrowers->book->author,
                    'from_date' => $borrowers->from_date,
                    'overdue_date' => $overdueDate,
                    'overdueBy' => $overdueBy,
                ];
            }
        }
        if (!empty($dataMail)) {
            dispatch(new SendBorrowerStatusChangeMail($dataMail));
        }
        if (!empty($arrId)) {
            $this->borrowerService->updateMultipleStatus($arrId, BorrowerEnums::STATUS_OVERDUE);
        }

        return Command::SUCCESS;
    }
}
