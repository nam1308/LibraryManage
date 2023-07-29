<?php

namespace App\Console\Commands;

use App\Services\Contracts\AdminNotificationServiceInterface;
use Illuminate\Console\Command;

class SendAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_announcement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Announcement';

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
    public function handle(AdminNotificationServiceInterface $adminNotificationService)
    {
        $adminNotificationService->sendMailAnnouncement();
        return 0;
    }
}
