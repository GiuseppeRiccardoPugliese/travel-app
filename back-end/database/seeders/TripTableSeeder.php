<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Trip;


class TripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leggo il contenuto del file JSON
        $json = File::get(database_path('data/trips.json'));

        // Decodifico il JSON in un array associativo
        $trips = json_decode($json, true);

        // Inserisco ogni viaggio nella tabella trips
        foreach ($trips as $tripData) {

            // Inserisco il viaggio e ottieni l'istanza del modello Trip
            $trip = Trip::create([
                'nome' => $tripData['nome'],
                'descrizione' => $tripData['descrizione'],
                'data_inizio' => $tripData['data_inizio'],
                'data_fine' => $tripData['data_fine'],
                'destinazione' => $tripData['destinazione'],
                'immagine' => $tripData['immagine'],
                'created_at' => $tripData['created_at'],
                'updated_at' => $tripData['updated_at'],
            ]);

            // Seleziono un utente casuale
            $user = User::inRandomOrder()->first();

            // Associo il viaggio all'utente
            $trip->users()->attach($user->id);
        }
       
    }
}
