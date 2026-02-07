<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerPointRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $volunteers = Volunteer::get();

        $now = Carbon::now();

        foreach ($volunteers as $volunteer) {
            for ($month = 1; $month <= 12; $month++) {
                VolunteerPointRating::create([
                    'volunteer_id'  => $volunteer->id,
                    'year'          => $now->year - 1,
                    'month'         => $month,
                    'rating_total'  => rand(10, 50),
                    'rating_count'  => rand(1, 10),
                    'point_total'   => rand(50, 200),
                ]);
            }

            for ($month = 1; $month <= $now->month; $month++) {
                VolunteerPointRating::create([
                    'volunteer_id'  => $volunteer->id,
                    'year'          => $now->year,
                    'month'         => $month,
                    'rating_total'  => rand(10, 50),
                    'rating_count'  => rand(1, 10),
                    'point_total'   => rand(50, 200),
                ]);
            }
        }
    }
}
