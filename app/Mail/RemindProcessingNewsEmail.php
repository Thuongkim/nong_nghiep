<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindProcessingNewsEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user, $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $name)
    {
        $this->user = $user;
        $this->name = $name;
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
        $name = $this->name;
        return $this->view('emails.remind_processing_news', compact('user', 'name'))->subject($user->fullname . (', bài dịch của bạn có gặp khó khăn?'));
    }
}
