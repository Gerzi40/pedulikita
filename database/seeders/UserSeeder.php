<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Andi',
            'email'=> 'v1@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'v1',
            'role' => 'volunteer'
        ]);
        User::create([
            'name' => 'Budi',
            'email'=> 'v2@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'v2',
            'role' => 'volunteer'
        ]);
        User::create([
            'name' => 'Charlotte',
            'email'=> 'v3@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'v3',
            'role' => 'volunteer'
        ]);
        User::create([
            'name' => 'Denis',
            'email'=> 'v4@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'v4',
            'role' => 'volunteer'
        ]);
        User::create([
            'name' => 'Ellen',
            'email'=> 'v5@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'v5',
            'role' => 'volunteer'
        ]);

        User::create([
            'name' => 'GoRelawan',
            'email'=> 'gorelawan@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'o1',
            'role' => 'organization',
            'profile_picture_url' => 'profiles/organizations/org1.png'
        ]);
        User::create([
            'name' => 'Cipta Semesta',
            'email'=> 'ciptasemestakita@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'o2',
            'role' => 'organization',
            'profile_picture_url' => 'profiles/organizations/org2.png'
        ]);

        User::create([
            'name' => 'Indonesia Hijau',
            'email'=> 'indonesiahijau@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'o3',
            'role' => 'organization',
            'profile_picture_url' => 'profiles/organizations/org3.png'
        ]);

        User::create([
            'name' => 'Peaceful World',
            'email'=> 'peaceworldco@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'o4',
            'role' => 'organization',
            'profile_picture_url' => 'profiles/organizations/org4.png'
        ]);

        User::create([
            'name' => 'SIKAPI Indonesia',
            'email'=> 'sikapindo@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'o5',
            'role' => 'organization',
            'profile_picture_url' => 'profiles/organizations/org5.png'
        ]);

        User::create([
            'name' => 'a1',
            'email'=> 'pedulikita2026@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'a1',
            'role' => 'admin'
        ]);
    }
}
