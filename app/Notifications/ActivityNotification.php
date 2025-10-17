<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $type = 'info')
    {
        $this->message = $message;
        $this->type = $type; // e.g., 'success', 'warning', 'error'
    }

    /**
     * Delivery channels
     */
    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    /**
     * Store in database
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'time' => now()->toDateTimeString(),
        ];
    }
}
