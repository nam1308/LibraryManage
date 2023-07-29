<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $newPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    public function build()
    {
        return $this->view('admin.mail.password_changed')
            ->subject('Thay đổi mật khẩu thành công');
    }

    public function attachments()
    {
        return [];
    }
}
