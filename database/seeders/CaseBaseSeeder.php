<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('case_base')->insert([
                'solar_irradiance' => rand(1, 10),
                'temperature' => rand(20, 30),
                'humidity' => rand(40, 80),
                'soilPH' => rand(5, 8),
                'crop_area' => rand(10, 100),
                'irrigation_duration' => rand(30, 120),
                'flow_rate' => rand(5, 20),
                'nozzle_type' => 'Nozzle' . rand(1, 5),
                'water_application_rate' => rand(5, 15),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
