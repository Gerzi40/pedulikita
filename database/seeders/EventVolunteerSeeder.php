<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventVolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::where('state', '=', 'approved')->get();

        foreach ($events as $event)
        {
            for ($i=1; $i<=rand(1, 5); $i++)
            {
                $event->volunteers()->attach($i);
            }
        }
    }
}
