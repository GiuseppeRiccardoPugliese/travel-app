<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        return view('trips.create', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $trip = Trip::find($request->trip_id);

        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $trip = Trip::find($request->trip_id);
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Estraggo tutti i dati dal request
        $data = $request->all();


        $trip = Trip::find($request->trip_id);
        $trip->nome = $data['nome'];
        $trip->descrizione = $data['descrizione'];
        $trip->data_inizio = $data['data_inizio'];
        $trip->data_fine = $data['data_fine'];
        $trip->destinazione = $data['destinazione'];

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
