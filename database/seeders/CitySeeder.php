<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create(['province_id' => 1, 'name' => 'Jakarta Barat']);
        City::create(['province_id' => 1, 'name' => 'Jakarta Pusat']);
        City::create(['province_id' => 1, 'name' => 'Jakarta Timur']);
        City::create(['province_id' => 1, 'name' => 'Jakarta Selatan']);
        City::create(['province_id' => 1, 'name' => 'Jakarta Utara']);

        City::create(['province_id' => 2, 'name' => 'Kota Bandung']);
        City::create(['province_id' => 2, 'name' => 'Bekasi']);
        City::create(['province_id' => 2, 'name' => 'Bogor']);
        City::create(['province_id' => 2, 'name' => 'Depok']);
        City::create(['province_id' => 2, 'name' => 'Cimahi']);

        City::create(['province_id' => 3, 'name' => 'Semarang']);
        City::create(['province_id' => 3, 'name' => 'Surakarta']);
        City::create(['province_id' => 3, 'name' => 'Magelang']);
        City::create(['province_id' => 3, 'name' => 'Salatiga']);

        City::create(['province_id' => 4, 'name' => 'Kota Yogyakarta']);
        City::create(['province_id' => 4, 'name' => 'Sleman']);
        City::create(['province_id' => 4, 'name' => 'Bantul']);

        City::create(['province_id' => 5, 'name' => 'Surabaya']);
        City::create(['province_id' => 5, 'name' => 'Malang']);
        City::create(['province_id' => 5, 'name' => 'Kediri']);
        City::create(['province_id' => 5, 'name' => 'Blitar']);
        City::create(['province_id' => 5, 'name' => 'Madiun']);

        City::create(['province_id' => 6, 'name' => 'Denpasar']);
        City::create(['province_id' => 6, 'name' => 'Ubud']);
        City::create(['province_id' => 6, 'name' => 'Gianyar']);

        City::create(['province_id' => 7, 'name' => 'Medan']);
        City::create(['province_id' => 7, 'name' => 'Binjai']);
        City::create(['province_id' => 7, 'name' => 'Pematangsiantar']);

        City::create(['province_id' => 8, 'name' => 'Padang']);
        City::create(['province_id' => 8, 'name' => 'Bukittinggi']);

        City::create(['province_id' => 9, 'name' => 'Palembang']);
        City::create(['province_id' => 9, 'name' => 'Lubuklinggau']);

        City::create(['province_id' => 10, 'name' => 'Tebing Tinggi']);
        City::create(['province_id' => 10, 'name' => 'Tanjungbalai']);

        City::create(['province_id' => 11, 'name' => 'Pekanbaru']);
        City::create(['province_id' => 11, 'name' => 'Dumai']);

        City::create(['province_id' => 12, 'name' => 'Bandar Lampung']);
        City::create(['province_id' => 12, 'name' => 'Metro']);

        City::create(['province_id' => 13, 'name' => 'Batam']);
        City::create(['province_id' => 13, 'name' => 'Tanjung Pinang']);

        City::create(['province_id' => 14, 'name' => 'Kabupaten Tangerang']);
        City::create(['province_id' => 14, 'name' => 'Serang']);

        City::create(['province_id' => 15, 'name' => 'Banda Aceh']);
        City::create(['province_id' => 15, 'name' => 'Lhokseumawe']);

        City::create(['province_id' => 16, 'name' => 'Pontianak']);
        City::create(['province_id' => 16, 'name' => 'Singkawang']);

        City::create(['province_id' => 17, 'name' => 'Balikpapan']);
        City::create(['province_id' => 17, 'name' => 'Samarinda']);

        City::create(['province_id' => 18, 'name' => 'Banjarmasin']);
        City::create(['province_id' => 18, 'name' => 'Banjarbaru']);

        City::create(['province_id' => 19, 'name' => 'Tarakan']);
        City::create(['province_id' => 19, 'name' => 'Nunukan']);

        City::create(['province_id' => 20, 'name' => 'Makassar']);
        City::create(['province_id' => 20, 'name' => 'Parepare']);
        City::create(['province_id' => 20, 'name' => 'Palopo']);

        City::create(['province_id' => 21, 'name' => 'Mamuju']);
        City::create(['province_id' => 21, 'name' => 'Polewali']);

        City::create(['province_id' => 22, 'name' => 'Manado']);
        City::create(['province_id' => 22, 'name' => 'Bitung']);

        City::create(['province_id' => 23, 'name' => 'Kendari']);
        City::create(['province_id' => 23, 'name' => 'Baubau']);
    }
}
