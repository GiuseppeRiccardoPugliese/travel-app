<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

use Illuminate\Support\Facades\Storage;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Cartella con il path relativo
        $directory = 'images/users_avatars';
        // Rimuovi l'intera directory e tutto il suo contenuto
        Storage::disk('public')->deleteDirectory($directory);


        //Una volta cancellata la cartella del LocalStorage, ricrei i 10 utenti con le relative img

        User::factory()->count(10)->make()->each(function($user){
            
            //Gen Profile_Pick in base alla sessualita' del soggetto & salvataggio nello Storage (images/users_avatars)

            $gender = $user->sessualità == 'uomo' ? 'male' : 'female';

            $imageUrl = "https://xsgames.co/randomusers/avatar.php?g={$gender}&random=";

            // Scarica l'immagine dall'URL
            $imageData = file_get_contents($imageUrl);

            // Genera un nome univoco per il file immagine
            $fileName = uniqid() . '.jpg';

            // Salva l'immagine scaricata nella directory di archiviazione pubblica
            Storage::disk('public')->put('images/users_avatars/' . $fileName, $imageData);

            // Costruisci l'URL completo per l'immagine salvata
            $imgPath = 'images/users_avatars/' . $fileName;

            // Assegna l'URL dell'immagine al campo corrispondente nel modello Teacher
            $user->immagine_url = $imgPath;

            // Salvo
            $user->save();
        });
    }
}
