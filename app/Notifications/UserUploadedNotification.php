<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserUploadedNotification extends Notification
{
    use Queueable;

    public $url;
    public $owner;
    public $title;
    public $image;
    public $created_at;
    public $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$url,$owner,$title,$image,$created_at)
    {
        $this->type = $type;
        $this->owner = $owner;
        $this->title = $title;
        $this->image = $image;
        $this->url = $url;
        $this->created_at = $created_at;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'type' => $this->type,
            'owner' => $this->owner,
            'title' => $this->title,
            'image' => $this->image,
            'url' => $this->url,
            'created_at' => $this->created_at,
        ];
    }
}
