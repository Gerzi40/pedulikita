<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'after' => ':attribute harus berupa tanggal setelah :date.',
    'before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':attribute harus antara :min dan :max.',
    ],
    'boolean' => ':attribute harus berupa true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'date_format' => ':attribute harus sesuai dengan format :format.',
    'decimal' => ':attribute harus memiliki :decimal angka di belakang koma.',
    'digits_between' => ':attribute harus antara :min sampai :max digit.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'lowercase' => ':attribute harus berupa huruf kecil.',
    'min' => [
        'string' => ':attribute harus memiliki minimal :min karakter.',
    ],
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus mengandung setidaknya satu huruf.',
        'mixed' => ':attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => ':attribute harus mengandung setidaknya satu angka.',
        'symbols' => ':attribute harus mengandung setidaknya satu simbol.',
    ],
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'unique' => ':attribute sudah digunakan.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'end_time' => [
            'after' => ':attribute harus berupa waktu setelah :date.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Kata Sandi',
        'gender' => 'Jenis Kelamin',
        'date_of_birth' => 'Tanggal Lahir',
        'available_slot' => 'Slot Tersedia',
        'date' => 'Tanggal',
        'start_time' => 'Acara Mulai',
        'end_time' => 'Acara Berakhir',
        'description' => 'Deskripsi',
        'location' => 'Lokasi',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'city' => 'Kota',
        'image' => 'Gambar',
        'organization_category_id' => 'Kategori Organisasi',
        'province_id' => 'Provinsi',
        'city_id' => 'Kota',
        'founded_at' => 'Tanggal Didaftarkan',
        'phone' => 'Nomor Telepon',
        'profile_picture' => 'Foto Profil',
        'is_present' => 'Kehadiran',
        'rating' => 'Nilai',
    ],

];
