<?php

namespace App\Jobs\User;

use App\Mail\User\BorrowerNotifyAutoRenew;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailBorrowerAutoRenew implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mailData;
    /**
     * 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailData = $this->mailData;
        $email = new BorrowerNotifyAutoRenew($mailData);
        Mail::to($mailData['email'])->send($email);
    }
}
