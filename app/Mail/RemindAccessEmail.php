<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindAccessEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->replyTo(env('MAIL_REPLY_ADDRESS'), env('MAIL_REPLY_NAME'));
        $user = $this->user;
        return $this->view('emails.reminder_access', compact('user'))->subject($user->fullname . ($user->last_login == null ? ' chúng tôi nhớ bạn!' : ' lâu rồi bạn chưa đăng nhập vào hệ thống!'));
    }
}
