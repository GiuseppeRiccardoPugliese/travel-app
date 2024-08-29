<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Trip;
use Carbon\Carbon;

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

            // DIFFERENZA tra data fine e inizio per calcolo durata del viaggio
            $date1 = Carbon::parse($tripData['data_fine']);
            $date2 = Carbon::parse($tripData['data_inizio']);

            $diffInDays = $date1->diffInDays($date2);
            // Inserisco il viaggio e ottieni l'istanza del modello Trip
            $trip = Trip::create([
                'nome' => $tripData['nome'],
                'descrizione' => $tripData['descrizione'],
                'data_inizio' => $tripData['data_inizio'],
                'data_fine' => $tripData['data_fine'],
                'destinazione' => $tripData['destinazione'],
                'votazione' => $tripData['votazione'],
                'immagine' => $tripData['immagine'],
                'durata_viaggio' => $diffInDays,
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
