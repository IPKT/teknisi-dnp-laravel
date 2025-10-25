<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisHardware;

class JenisHardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisHardware::create(['jenis' => 'UPS']);
        JenisHardware::create(['jenis' => 'Sensor']);
    }
}