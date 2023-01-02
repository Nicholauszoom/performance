<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $email_data;
    public function __construct(array $email_data)
    {
        //
        $this->arr=$email_data;

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
        return (new MailMessage)
            ->subject('VSO User Credentials')
            ->greeting('Dear ' . $this->arr['username'])
            ->salutation('Your Flex Performance Account login credential are  username:' . $this->arr['username'] . ' and password ' . $this->arr['password'])
            ->line('You are advised not to share your password with anyone. If you dont know this activity or you received this email by accident, please report this incident to the system administrator')
            ->action('Login Link', url('/login'))
            ->line('Thank you')
            ->line('Flex Performance Software Self Service');
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
