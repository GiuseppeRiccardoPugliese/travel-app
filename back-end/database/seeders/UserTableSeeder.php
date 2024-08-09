<?php

namespace Database\Seeders;

use App\Models\Trip;
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


        //Una volta cancellata la cartella del LocalStorage, ricreo i 10 utenti con le relative img

        User::factory()->count(10)->make()->each(function($user){
            
            //Gen Profile_Pick in base alla sessualita' del soggetto & salvataggio nello Storage (images/users_avatars)

            $gender = $user->sessualità == 'uomo' ? 'male' : 'female';

            $imageUrl = "https://xsgames.co/randomusers/avatar.php?g={$gender}&random=";

            // Scarico l'immagine dall'URL
            $imageData = file_get_contents($imageUrl);

            // Genero un nome univoco per il file immagine
            $fileName = uniqid() . '.jpg';

            // Salvo l'immagine scaricata nella directory di archiviazione pubblica
            Storage::disk('public')->put('images/users_avatars/' . $fileName, $imageData);

            // Costruisco l'URL completo per l'immagine salvata
            $imgPath = 'images/users_avatars/' . $fileName;

            // Assegno l'URL dell'immagine al campo corrispondente nel modello Teacher
            $user->immagine_url = $imgPath;

            // Salvo
            $user->save();
        });
    }
}
