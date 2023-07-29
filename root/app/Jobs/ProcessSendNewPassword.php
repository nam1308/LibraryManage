<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class ProcessSendNewPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $messageData;
    protected $email;
    /**
     * 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messageData, $email)
    {
        $this->messageData = $messageData;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailUser=$this->email;
        Mail::send('users.mail.new_password',$this->messageData,function($message)
                 use ($emailUser){
                    $message->to($emailUser)->subject('Đặt Lại Mật Khẩu Mới');
                });
    }
}
