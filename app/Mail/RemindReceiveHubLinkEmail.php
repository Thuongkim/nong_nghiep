<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindReceiveHubLinkEmail extends Mailable
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
        return $this->view('emails.remind_receive_hublink', compact('user'))->subject($user->fullname . ' có bài dịch phù hợp với chuyên môn của bạn!');
    }
}
