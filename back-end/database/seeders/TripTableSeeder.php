<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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

        //Cartella con il path relativo
        $directory = 'images/tripsDefault';
        // Rimuovi l'intera directory e tutto il suo contenuto
        Storage::disk('public')->deleteDirectory($directory);

        // Inserisco ogni viaggio nella tabella trips
        foreach ($trips as $tripData) {

            // DIFFERENZA tra data fine e inizio per calcolo durata del viaggio
            $date1 = Carbon::parse($tripData['data_fine']);
            $date2 = Carbon::parse($tripData['data_inizio']);

            $diffInSeconds = $date1->diffInSeconds($date2);

            // Converto i secondi in giorni (1 giorno = 86400 secondi)
            $diffInDays = $diffInSeconds / 86400;


            // Inserisco il viaggio e ottieni l'istanza del modello Trip
            $trip = Trip::create([
                'nome' => $tripData['nome'],
                'descrizione' => $tripData['descrizione'],
                'data_inizio' => $tripData['data_inizio'],
                'data_fine' => $tripData['data_fine'],
                'destinazione' => $tripData['destinazione'],
                'votazione' => $tripData['votazione'],
                'immagine' => $this->fetchAndStoreImage($tripData['destinazione']),
                'durata_viaggio' => $diffInDays + 1,
                'created_at' => $tripData['created_at'],
                'updated_at' => $tripData['updated_at'],
            ]);

            // Seleziono un utente casuale
            $user = User::inRandomOrder()->first();

            // Associo il viaggio all'utente
            $trip->users()->attach($user->id);
        }

    }
    private function fetchAndStoreImage($destination)
    {
        $client_id = 'QngG7sfBVMWvG3kVsWuLqkCRWftkIHIqNHRRsI6fp0I';
        // Effettua una richiesta GET a Unsplash per la destinazione
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://api.unsplash.com/search/photos', [
                    'query' => $destination,
                    'per_page' => 1,
                    'client_id' => $client_id,
                ]);


        // Controlla se la richiesta è andata a buon fine
        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['results'][0])) {
                $imageData = $data['results'][0];

                $imageUrl = $imageData['urls']['regular'];


            } else {
                $imageUrl = 'https://media.istockphoto.com/id/1409329028/vector/no-picture-available-placeholder-thumbnail-icon-illustration-design.jpg?s=612x612&w=0&k=20&c=_zOuJu755g2eEUioiOUdz_mHKJQJn-tDgIAhQzyeKUQ=';
                $this->command->info("Nessuna immagine trovata per $destination.");
            }
            // Scarica l'immagine
            $imageContent = file_get_contents($imageUrl);
            $imageName = uniqid() . '.jpg';

            // Salva l'immagine nel filesystem
            Storage::disk('public')->put('images/tripsDefault/' . $imageName, $imageContent);
            $imagePath = 'images/tripsDefault/' . $imageName;

            return $imagePath;
        } else {
            $this->command->error("Errore nella richiesta per $destination: " . $response->status());
        }
    }
}

