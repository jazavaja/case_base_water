<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolveCBR extends Command
{
    protected $signature = 'cbr:solve';
    protected $description = 'Solve a problem using Case-Based Reasoning';


// Custom function to ask with validation
    private function askWithValidation($question, $validation)
    {
        $value = $this->ask($question);

        // Continue asking until the input passes validation
        while (!$validation($value)) {
            $this->error('Invalid input. Please try again.');
            $value = $this->ask($question);
        }

        return $value;
    }
    public function handle()
    {
        $newProblem = [
            'solar_irradiance' => $this->askWithValidation('Enter solar irradiance (between 1 and 10):', function ($value) {
                return is_numeric($value) && $value >= 1 && $value <= 10;
            }),

            'temperature' => $this->askWithValidation('Enter temperature (between 5 and 30):', function ($value) {
                return is_numeric($value) && $value >= 5 && $value <= 30;
            }),

            'humidity' => $this->askWithValidation('Enter humidity (between 40 and 80):', function ($value) {
                return is_numeric($value) && $value >= 40 && $value <= 80;
            }),

            'soilPH' => $this->askWithValidation('Enter soil pH (between 5 and 8):', function ($value) {
                return is_numeric($value) && $value >= 5 && $value <= 8;
            }),

            'crop_area' => $this->askWithValidation('Enter crop area (positive numeric value 1000 to 2000):', function ($value) {
                return is_numeric($value) && $value >= 1000 && $value <= 2000;
            }),
        ];

        // Retrieve similar cases
        $similarCases = $this->retrieveSimilarCases($newProblem);

        // Adapt the solution
        $adaptedSolution = $this->adaptSolution($similarCases);

        // Display the adapted solution
        $this->info('Adapted Solution:');
        $this->table(['Parameter', 'Value'], $adaptedSolution);
    }

    private function retrieveSimilarCases($newProblem)
    {
        // Set a similarity threshold, adjust as needed
        $similarityThreshold = 30;

        // Query the case_base table to retrieve similar cases
        $allCases = DB::table('case_base')->get();

        // Calculate distances and filter similar cases
        $similarCases = [];
        foreach ($allCases as $case) {
            $distance = $this->calculateEuclideanDistance($newProblem, (array) $case);

            if ($distance < $similarityThreshold) {
                $similarCases[] = (array) $case;
            }
        }

        return $similarCases;
    }

    private function calculateEuclideanDistance($problem1, $problem2)
    {
        // Calculate Euclidean distance between two problems
        $sum = 0;

        foreach ($problem1 as $key => $value) {
            $sum += pow($value - $problem2[$key], 2);
        }

        return sqrt($sum);
    }

    private function adaptSolution($similarCases)
    {
        // Check if no similar cases were found
        if (empty($similarCases)) {
            // Handle the case where no similar cases were found
            // You can return a default solution or use a fallback strategy
            return [
                ['irrigation_duration', 0],
                ['flow_rate', 0],
                ['nozzle_id', 'DefaultNozzle'],
                ['water_application_rate', 0],
            ];
        }

        // Initialize variables to store aggregated values
        $totalIrrigationDuration = 0;
        $totalFlowRate = 0;
        $nozzleTypes = [];
        $totalWaterApplicationRate = 0;

        // Iterate through similar cases and aggregate solutions
        foreach ($similarCases as $case) {
            $totalIrrigationDuration += $case['irrigation_duration'];
            $totalFlowRate += $case['flow_rate'];
            $nozzleTypes[] = $case['nozzle_id'];
            $totalWaterApplicationRate += $case['water_application_rate'];
        }

        // Calculate average solutions
        $averageIrrigationDuration = $totalIrrigationDuration / count($similarCases);
        $averageFlowRate = $totalFlowRate / count($similarCases);

        // Select the most common nozzle type
        $mostCommonNozzle = array_reduce(
            $nozzleTypes,
            function ($mostCommon, $currentNozzle) use ($nozzleTypes) {
                return ($mostCommon['count'] > ($currentNozzleCount = count(array_keys($nozzleTypes, $currentNozzle)))) ? $mostCommon : ['type' => $currentNozzle, 'count' => $currentNozzleCount];
            },
            ['type' => null, 'count' => 0]
        )['type'];

        $averageWaterApplicationRate = $totalWaterApplicationRate / count($similarCases);

        // Return the adapted solutions
        return [
            ['irrigation_duration (minutes)', $averageIrrigationDuration],
            ['flow_rate (liters per minute)', $averageFlowRate],
            ['nozzle_type', $mostCommonNozzle],
            ['water_application_rate (mm/hour)', $averageWaterApplicationRate],
        ];
    }
}

