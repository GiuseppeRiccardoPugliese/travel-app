<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TripRequest;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Filtro per l'autenticazione dello user con l'id
        $trips = Trip::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();


        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trips = Trip::all();
        $dateToday = Carbon::now()->format('Y-m-d');
        return view('trips.create', compact('trips', 'dateToday'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TripRequest $request)
    {
        // Estraggo tutti i dati dal request
        $data = $request->all();

        // Creo una nuova istanza di Trip e assegna i valori
        $trip = new Trip();
        $trip->nome = $data['nome'];
        $trip->descrizione = $data['descrizione'];
        $trip->data_inizio = $data['data_inizio'];
        $trip->data_fine = $data['data_fine'];
        $trip->destinazione = $data['destinazione'];

        $date1 = Carbon::parse($data['data_fine']);
        $date2 = Carbon::parse($data['data_inizio']);

        $diffInSeconds = $date1->diffInSeconds($date2);

        // Converto i secondi in giorni (1 giorno = 86400 secondi)
        $diffInDays = $diffInSeconds / 86400;
        $trip->durata_viaggio = $diffInDays+1;

        // Gestione dell'immagine
        if ($request->hasFile('immagine')) {
            $imagePath = $request->file('immagine')->store('images', 'public');
            $trip->immagine = $imagePath;
        }

        // Salvo il viaggio nel database
        $trip->save();

        // Associo il trip all'utente autenticato
        $trip->users()->attach(Auth::id());

        // Reindirizzo alla pagina index con un messaggio di successo
        return redirect()->route('trip.index')->with('success', 'Viaggio creato con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->session()->forget('codice');
        $request->session()->forget('trip');

        // $trip = Trip::find($request->trip_id);
        $trip = Trip::with('journeyStages')->findOrFail($request->trip_id);

        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $trip = Trip::find($request->trip_id);
        $data_inizio = $trip->data_inizio;
        $data_fine = $trip->data_fine;
        return view('trips.edit', compact('trip', 'data_inizio', 'data_fine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TripRequest $request)
    {
        // Estraggo tutti i dati dal request
        $data = $request->all();

        $trip = Trip::find($request->trip_id);
        $trip->nome = $data['nome'];
        $trip->descrizione = $data['descrizione'];
        $trip->data_inizio = $data['data_inizio'];
        $trip->data_fine = $data['data_fine'];
        $trip->destinazione = $data['destinazione'];
        $trip->votazione = $data['valutazione'];

        $date1 = Carbon::parse($data['data_fine']);
        $date2 = Carbon::parse($data['data_inizio']);

        $diffInSeconds = $date1->diffInSeconds($date2);

        // Converto i secondi in giorni (1 giorno = 86400 secondi)
        $diffInDays = $diffInSeconds / 86400;
        $trip->durata_viaggio = $diffInDays+1;
        // Gestione dell'immagine
        if ($request->hasFile('immagine')) {
            $imagePath = $request->file('immagine')->store('images', 'public');
            $trip->immagine = $imagePath;
        }

        // Salvo il viaggio nel database
        $trip->save();

        // Reindirizzo alla pagina index con un messaggio di successo
        return redirect()->route('trip.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $trip = Trip::find($request->trip_id);

        if ($trip->users()->count() > 1) {

            $trip->users()->detach(Auth::id());

        } else {
            $trip->users()->detach();

            $trip->journeyStages()->delete();


            $trip->delete();
        }

        return redirect()->route('trip.index');
    }
}
