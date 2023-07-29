<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\UpdateUserNotify;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendChangeNewMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $websiteLink;
    public $oldMail;
    public $user;
    public $newMail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $oldMail, $newMail, $websiteLink)
    {
        $this->user = $user;
        $this->oldMail = $oldMail;
        $this->newMail = $newMail;
        $this->websiteLink = $websiteLink;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $mailOld = $this->oldMail;
        $mailNew = $this->newMail;
        $linkWebsite= $this->websiteLink;
        $email = new UpdateUserNotify($user, $mailOld, $mailNew, $linkWebsite);
        Mail::to($mailNew)->send($email);
        Mail::to($mailOld)->send($email);
    }
}
