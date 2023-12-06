<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cbr:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('nozzle')->insert([
                    'type' => 'Nozzle' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }catch (\Exception $e){

        }

        $listNozzle = DB::table('nozzle')->pluck('id')->toArray(); // Get an array of nozzle IDs

        for ($i = 1; $i <= 2000; $i++) {

            $nozzleId = $listNozzle[array_rand($listNozzle)]; // Randomly select a nozzle ID from the list

            DB::table('case_base')->insert([
                'solar_irradiance' => rand(1, 10),
                'temperature' => rand(5, 30),
                'humidity' => rand(40, 80),
                'soilPH' => rand(5, 8),
                'crop_area' => rand(1000, 2000),
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
