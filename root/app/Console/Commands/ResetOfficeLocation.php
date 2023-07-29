<?php

namespace App\Console\Commands;

use App\Services\Contracts\TaxAdvisorInfoServiceInterface;
use Illuminate\Console\Command;

class ResetOfficeLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reset_office_location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Location Office When Out Of Date';

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
    public function handle(TaxAdvisorInfoServiceInterface $taxAdvisorInfoService)
    {
        $conditions = [
            ['location_expiration_date', 'DATE <=', date("Y-m-d")]
        ];

        $taxAdvisorInfoService->checkLocationSaveTime($conditions);
        return 0;
    }
}
