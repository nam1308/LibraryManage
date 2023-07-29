<?php

namespace App\Console\Commands;

use App\Services\Api\ViewOfficeAccessInformationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetViewOfficeAccessDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reset_access_day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset View Office Access Day And Month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ViewOfficeAccessInformationService $viewOfficeAccess)
    {
        $conditions = [
            'users_role' => ROLES['guest']
        ];

        $firstDayOfMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $data = [
            'access_day' => ACCESS_COUNT_DEFAULT
        ];

        if (date("Y-m-d") == $firstDayOfMonth) {
            $data['access_month'] = ACCESS_COUNT_DEFAULT;
        }

        $viewOfficeAccess->resetCountAccess($conditions, $data);
        return 0;
    }
}
