<?php

namespace App\Mail\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateUserNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $websiteLink;
    public $oldMail;
    public $user;
    public $newMail;

    /**
     * Create a new message instance.
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

    public function build()
    {
        return $this->view('admin.mail.update-user')
            ->subject('Thay đổi email thành công');
    }

    public function attachments()
    {
        return [];
    }
}
