<?php

namespace App\Console\Commands;

use App\Jobs\ProcessNotification;
use Illuminate\Console\Command;
use App\Models\UserNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckScheduledNotifications extends Command
{
    protected $signature = 'notifications:check';
    protected $description = 'Check for scheduled notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current date and time in the server's timezone
        $currentDateTime = now();
        Log::info("currentDateTime $currentDateTime");

        // Fetch notifications
        $notifications = UserNotification::get();

        // loop through the notifications
        foreach ($notifications as $notification) {
            // Get the user's timezone
            $userTimezone = $notification->user->timezone;

            // Get the scheduled_at time
            $scheduledTime = $notification->scheduled_at;

            // Create a Carbon instance for your local time
            $localTime = Carbon::parse("$scheduledTime", "$userTimezone");

            // Convert the local time to UTC
            $utcTime = $localTime->utc();

            // Compare the scheduled time in the user's timezone with the current time
            if ($currentDateTime->eq($utcTime)) {
                Log::info($notification->user->name . " scheduled at  $notification->scheduled_at has been triggered.");

                // Calculate and set the next scheduled time based on the frequency
                $nextScheduledTime = $this->calculateNextScheduledTime($notification);
                $notification->update(['scheduled_at' => $nextScheduledTime]);
            }
        }
    }

    private function calculateNextScheduledTime($notification)
    {
        $currentScheduledTime = $notification->scheduled_at;
        $frequency = $notification->frequency;

        switch ($frequency) {
            case 'daily':
                return $currentScheduledTime->addDay();
            case 'weekly':
                return $currentScheduledTime->addWeek();
            case 'monthly':
                return $currentScheduledTime->addMonth();
            default:
                return $currentScheduledTime;
        }
    }
}
