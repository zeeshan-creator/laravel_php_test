<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // Define an array of timezones
        $timezones = [
            'America/New_York',
            'Asia/Tokyo',
            'Asia/Karachi', // Added Pakistan timezone
            'Asia/Kolkata', // Added India timezone
            'Asia/Dubai',   // Added UAE timezone
        ];

        // Generate at least 20 user records with different timezones
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('12345678'),
                'timezone' => $faker->randomElement($timezones),
            ]);
        }
    }
}
