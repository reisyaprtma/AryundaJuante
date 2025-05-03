<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'), // pastikan dienkripsi
            'birthdate' => null,
            'role' => 'admin', // asumsi tabel users punya kolom role
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

