<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            VolunteerSeeder::class,
            VolunteerPointRatingSeeder::class,
            OrganizationCategorySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            OrganizationSeeder::class,
            EventCategorySeeder::class,
            EventSeeder::class,
            EventVolunteerSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
