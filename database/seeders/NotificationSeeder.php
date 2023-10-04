<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // All users
        $users = DB::table('users')->get();

        // Array of frequencies
        $frequencies = ['daily', 'weekly', 'monthly'];

        // Scheduled notifications for users
        for ($i = 0; $i < 20; $i++) {
            $user = $faker->randomElement($users);
            $scheduledTime = $faker->time('H:i');
            $frequency = $faker->randomElement($frequencies);

            $notificationMessage = "Hello $user->name,\n" .
                "This is a notification for you. Your email address is: $user->email.\n" .
                "You have a scheduled event at $scheduledTime in your local timezone.\n" .
                "Thank you for using our notification system.\n" .
                "Best regards,\n";

            // Current date with the scheduled time
            $scheduledDateTime = now()->setTimeFromTimeString($scheduledTime);

            DB::table('user_notifications')->insert([
                'user_id' => $user->id,
                'scheduled_at' => $scheduledDateTime,
                'frequency' => $frequency,
                'notification_message' => $notificationMessage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
