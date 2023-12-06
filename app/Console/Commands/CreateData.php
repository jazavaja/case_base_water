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
            for ($i = 1; $i <= 2; $i++) {
                DB::table('nozzle')->insert([
                    'type' => 'Nozzle' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }catch (\Exception $e){

        }

        $listNozzle = DB::table('nozzle')->pluck('id')->toArray(); // Get an array of nozzle IDs

        for ($i = 1; $i <= 3000; $i++) {

            $nozzleId = $listNozzle[array_rand($listNozzle)]; // Randomly select a nozzle ID from the list

            $solar_irradiance = rand(1, 10);
            $temperature = rand(5, 30);
            $humidity = rand(40, 80);
            $soilPH = rand(0, 14);

            $irrigation_duration = ($solar_irradiance + $temperature + $humidity) / 3;
            $flow_rate = $temperature * 1.2 + $soilPH * 0.5;
            $water_application_rate = $solar_irradiance * 0.8 - $soilPH * 0.2;

            DB::table('case_base')->insert([
                'solar_irradiance' => $solar_irradiance,
                'temperature' => $temperature,
                'humidity' => $humidity,
                'soilPH' => $soilPH,
                'irrigation_duration' => $irrigation_duration,
                'flow_rate' => $flow_rate,
                'nozzle_id' => $nozzleId,
                'water_application_rate' => $water_application_rate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
