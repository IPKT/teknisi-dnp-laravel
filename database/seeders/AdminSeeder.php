<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nama_lengkap' => 'Administrator BMKG',
            'nip' => '1234567890',
        ]);
    }
}