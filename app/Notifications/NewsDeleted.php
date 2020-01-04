<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class NewsDeleted extends Notification implements ShouldQueue
{
    use Queueable;
    protected $user, $news, $creator;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $news, $creator = null)
    {
        $this->user = $user;
        $this->news = $news;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];//'mail',
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $news = $this->news;
        return (new SlackMessage)
        ->error()
        ->from(env("APP_NAME"), asset('assets/favicons/favicon-32x32.png'))
        ->content(is_null($this->creator) ? "[QTV] " . $this->user->fullname . " đỡ gỡ bài viết khỏi hệ thống!" : "Tác giả " . $this->creator->fullname . " đỡ gỡ bài viết khỏi hệ thống!")
        ->attachment(function ($attachment) use ($news) {
            $attachment->title($news->title, '#')->content(date("d/m/Y H:i", strtotime($news->deleted_at)));
        });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
