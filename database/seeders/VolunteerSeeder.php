<?php

namespace Database\Seeders;

use App\Models\Volunteer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Volunteer::create([
            'user_id' => 1,
            'gender' => 'male',
            'date_of_birth' => '2025-01-01'
        ]);
        Volunteer::create([
            'user_id' => 2,
            'gender' => 'female',
            'date_of_birth' => '2025-02-01'
        ]);
        Volunteer::create([
            'user_id' => 3,
            'gender' => 'male',
            'date_of_birth' => '2025-03-01'
        ]);
        Volunteer::create([
            'user_id' => 4,
            'gender' => 'female',
            'date_of_birth' => '2025-04-01'
        ]);
        Volunteer::create([
            'user_id' => 5,
            'gender' => 'male',
            'date_of_birth' => '2025-05-01'
        ]);
    }
}
