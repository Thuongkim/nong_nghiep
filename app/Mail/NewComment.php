<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class NewComment extends Mailable
{
    use Queueable, SerializesModels;

    private $news;
    private $comment;
    private $user;
    private $creator;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $news, $comment, $creator=null)
    {
        $this->news = $news;
        $this->user = $user;
        $this->comment = $comment;
        $this->creator = $creator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $news = $this->news;
        $user = $this->user;
        $this->replyTo(env('MAIL_REPLY_ADDRESS'), env('MAIL_REPLY_NAME'));
        return $this->view('emails.new_comment', ['news' => $this->news, 'comment' => $this->comment,  'user' => $this->user, 'creator' => $this->creator])->subject((is_null($this->creator) ? "[CTV] " . $user->fullname : "[QVT] " . $user->fullname) . ' đã thêm tin nhắn cho bài viết: ' . $news->title);
    }
}
