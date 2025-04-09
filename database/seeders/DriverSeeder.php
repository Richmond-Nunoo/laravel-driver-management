<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Generate 50 driver records
        for ($i = 0; $i < 50; $i++) {
            DB::table('drivers')->insert([
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'truck_type' => $faker->randomElement(['Tipper', 'Flatbed', 'Tanker', 'Container Carrier']),
                'document_path' => 'documents/' . $faker->word . '.pdf',  // Simulating a document path
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at' => Carbon::now()->subDays(rand(1, 7)),  // Random date in the past week
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
