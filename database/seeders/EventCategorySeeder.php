<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventCategory::create(['name' => 'Pendidikan']);
        EventCategory::create(['name' => 'Kesehatan']);
        EventCategory::create(['name' => 'Lingkungan']);
        EventCategory::create(['name' => 'Infrastruktur']);
        EventCategory::create(['name' => 'Kesejehteraan']);
    }
}
