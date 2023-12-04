<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseBaseSeeder extends Seeder
{
    public function run()
    {
        // Seed the nozzle table first
        $this->call(NozzleSeeder::class);

        // Seed the case_base table
        for ($i = 1; $i <= 500; $i++) {
            $nozzleId = rand(1, 5); // Assuming 5 records in the nozzle table

            DB::table('case_base')->insert([
                'solar_irradiance' => rand(1, 10),
                'temperature' => rand(5, 30),
                'humidity' => rand(40, 80),
                'soilPH' => rand(5, 8),
                'crop_area' => rand(10, 2000),
                'irrigation_duration' => rand(30, 120),
                'flow_rate' => rand(5, 20),
                'nozzle_id' => $nozzleId,
                'water_application_rate' => rand(5, 15),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
