<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\FcmMessage;

class LeaveRequestApprovedNotification extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm']; // Use the FCM channel for push notifications
    }

    /**
     * Get the FCM representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\FcmMessage
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'title' => 'Leave Request Approved',
                'body' => 'Your leave request has been approved.',
            ]);
    }
}
