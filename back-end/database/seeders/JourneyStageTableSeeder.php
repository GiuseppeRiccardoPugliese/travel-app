<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Trip;
use App\Models\JourneyStage;


class JourneyStageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leggo il contenuto del file JSON
        $json = File::get(database_path('data/journeystages.json'));

        // Decodifico il JSON in un array associativo
        $stages = json_decode($json, true);

        // Inserisco ogni tappa nella tabella stages
        foreach ($stages as $stageData) {
            // Trovo il viaggio associato tramite il trip_id
            $trip = Trip::find($stageData['trip_id']);

            // Verifico che il viaggio esista
            if (!$trip) {
                // Opzionalmente, loggo un errore o salto questa tappa
                \Log::warning("Trip with ID {$stageData['trip_id']} does not exist. Skipping stage.");
                continue;
            }

            // Creo e salvo la tappa
            DB::table('journey_stages')->insert([
                'nome' => $stageData['nome'],
                'descrizione' => $stageData['descrizione'],
                'posizione' => $stageData['posizione'],
                'data' => $stageData['data'],
                'ordine' => $stageData['ordine'],
                'completata' => $stageData['completata'],
                'created_at' => $stageData['created_at'],
                'updated_at' => $stageData['updated_at'],
                'trip_id' => $stageData['trip_id'],
            ]);
        }
    }
}
