<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePost extends Mailable
{
    use Queueable, SerializesModels;

    private $news;
    private $original;
    private $user;
    private $changeAttributes;
    private $creator;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $changeAttributes, $news, $original, $creator=null)
    {
        $this->news = $news;
        $this->user = $user;
        $this->changeAttributes = $changeAttributes;
        $this->creator = $creator;
        $this->original = $original;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $changeAttributes = $this->changeAttributes;
        $news = $this->news;
        $approved = 0;
        if (isset($changeAttributes['status']) && $changeAttributes['status']) {
            $approved = 1;
        }
        $this->replyTo(env('MAIL_REPLY_ADDRESS'), env('MAIL_REPLY_NAME'));
        return $this->view('emails.update_post', ['news' => $this->news, 'original' => $this->original,  'user' => $this->user, 'changeAttributes' => $this->changeAttributes, 'creator' => $this->creator])->subject(($approved ? "Đã duyệt bài viết: " : "Cập nhật bài viết: ") . $news->title);
    }
}
