<?php

namespace Database\Seeders;

use App\Models\OrganizationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrganizationCategory::create([
            'name' => 'Pemerintah'
        ]);
        OrganizationCategory::create([
            'name' => 'Swasta'
        ]);
    }
}
