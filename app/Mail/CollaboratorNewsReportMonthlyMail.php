<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CollaboratorNewsReportMonthlyMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $news;
    protected $title;
    protected $month;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $news, $title, $month)
    {
        $this->user = $user;
        $this->news = $news;
        $this->title = $title;
        $this->month = $month;
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
        $news = $this->news;
        $month= $this->month;
        return $this->view('emails.report_collaborator_news_monthly', compact('user', 'news', 'month'))->subject($this->title);
    }
}
