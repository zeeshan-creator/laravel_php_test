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

        // Array of timezones
        $timezones = [
            'America/New_York',
            'Asia/Tokyo',
            'Asia/Karachi',
            'Asia/Kolkata',
            'Asia/Dubai',
        ];

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
