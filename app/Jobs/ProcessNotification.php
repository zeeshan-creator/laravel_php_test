<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserNotification;

class ProcessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;

    public function __construct(UserNotification $notification)
    {
        $this->notification = $notification;
    }

    public function handle()
    {
        // Check if it's time to send the notification based on the specified criteria
        if ($this->notification->shouldSendNow()) {
            // Log or send the notification as needed
            // You can access the notification's message, user, and other properties here
            // Example: Log::info('Notification sent: ' . $this->notification->notification_message);
        }
    }
}
