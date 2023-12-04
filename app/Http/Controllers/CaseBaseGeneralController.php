<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseBaseGeneralController extends Controller
{

    function calculateEuclideanDistance($problem1, $problem2) {
        // Calculate Euclidean distance between two problems
        $sum = 0;

        $sum += pow($problem1['solar_irradiance'] - $problem2['solar_irradiance'], 2);
        $sum += pow($problem1['temperature'] - $problem2['temperature'], 2);
        $sum += pow($problem1['humidity'] - $problem2['humidity'], 2);
        $sum += pow($problem1['soilPH'] - $problem2['soilPH'], 2);
        $sum += pow($problem1['crop_area'] - $problem2['crop_area'], 2);

        return sqrt($sum);
    }

    function retrieveSimilarCases($newProblem) {
        // Set a threshold for similarity, adjust as needed
        $similarityThreshold = 5.0;

        // Query the case_base table to retrieve similar cases
        $allCases = DB::table('case_base')->get();

        // Calculate distances and filter similar cases
        $similarCases = [];
        foreach ($allCases as $case) {
            $distance = $this->calculateEuclideanDistance($newProblem, (array)$case);

            if ($distance < $similarityThreshold) {
                $similarCases[] = (array)$case;
            }
        }

        return $similarCases;
    }

    function adaptSolution($similarCases) {
        if (empty($similarCases)) {
            // Handle the case where no similar cases were found
            return null;
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
            $nozzleTypes[] = $case['nozzle_type'];
            $totalWaterApplicationRate += $case['water_application_rate'];
        }

        // Calculate average solutions
        $averageIrrigationDuration = $totalIrrigationDuration / count($similarCases);
        $averageFlowRate = $totalFlowRate / count($similarCases);

        // Select the most common nozzle type
        $mostCommonNozzle = array_reduce($nozzleTypes, function ($mostCommon, $currentNozzle) use ($nozzleTypes) {
            return ($mostCommon['count'] > ($currentNozzleCount = count(array_keys($nozzleTypes, $currentNozzle))))
                ? $mostCommon
                : ['type' => $currentNozzle, 'count' => $currentNozzleCount];
        }, ['type' => null, 'count' => 0])['type'];

        $averageWaterApplicationRate = $totalWaterApplicationRate / count($similarCases);

        // You can return the adapted solutions or apply additional logic if needed
        return [
            'irrigation_duration' => $averageIrrigationDuration,
            'flow_rate' => $averageFlowRate,
            'nozzle_type' => $mostCommonNozzle,
            'water_application_rate' => $averageWaterApplicationRate,
        ];
    }

}
