<?php

namespace App\Jobs\User;

use App\Mail\User\RenewalBookNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessSendMailRenewalBook implements ShouldQueue
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
        $email = new RenewalBookNotify($mailData);
        Mail::to($mailData['email'])->send($email);
        
        // Gửi email cho tất cả các admin
        Mail::to($mailData['emailAdmin'])->send($email);
    }
}


