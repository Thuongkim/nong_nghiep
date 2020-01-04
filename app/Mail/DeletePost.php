<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletePost extends Mailable
{
    use Queueable, SerializesModels;

    private $news;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $news)
    {
        $this->news = $news;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $news = $this->news;
        $this->replyTo(env('MAIL_REPLY_ADDRESS'), env('MAIL_REPLY_NAME'));
        return $this->view('emails.delete_post', ['news' => $this->news, 'user' => $this->user])->subject("Bài viết của bạn đã bị gỡ bỏ khỏi hệ thống: " . $news->title);
    }
}
