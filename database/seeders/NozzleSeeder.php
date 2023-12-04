<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NozzleSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('nozzle')->insert([
                'type' => 'Nozzle' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
