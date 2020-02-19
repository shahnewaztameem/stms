<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $task;
    protected $phase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $task, $phase)
    {
        $this->user = $user;
        $this->task = $task;
        $this->phase = $phase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->user->user_type == 2) {
            $url = url('/user/task/view/' . $this->task->slug);
        } else {
            $url = url('/admin/task/view/' . $this->task->slug);
        }
        return (new MailMessage)
            ->subject('Client Feedback')
            ->greeting('Hello '.$this->user->name."!")
            ->line('Feedback received from Client for '.$this->phase.' phase')
            ->line('Task Title: ' . $this->task->title)
            ->action('See Details', $url)
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
            //
        ];
    }
}