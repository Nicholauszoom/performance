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
            ->subject('HC HUB User Credentials')
            // ->to($this->arr['email'])
            // ->to($this->arr['email'])
            // ->greeting('Dear ' . $this->arr['username'])
            ->greeting('Dear '. $this->arr['fname'] . ' ' . $this->arr['lname'])
            ->line('Your  HC-HUB Account login credentials are: ')
            ->line('Username: ' . $this->arr['username'])
            ->line('Password: ' . $this->arr['password'])
            ->line('You are advised not to share your password with anyone. If you don\'t know this activity or you received this email by accident, please report this incident to the system administrator')
            ->action('Login Link', url('/login'))
            ->line('Thank you')
            ->line('HC-HUB Software Self Service');
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
