<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JourneyStage;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;


class JourneyStagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($trip_id)
    {
        // Recupero il viaggio specifico
        $trip = Trip::findOrFail($trip_id);

        // Recupero gli stages relativi a quel viaggio
        $stages = $trip->journeyStages;

        // Passo i dati alla vista
        return view('trips.show', compact('trip', 'stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $trip_id)
    {
        // Trovo il viaggio e verifico che appartenga all'utente autenticato
        $trip = Trip::where('id', $trip_id)
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })->first();

        // Se il viaggio non esiste o non appartiene all'utente, lo reinderizzo alla index dei viaggi
        if (!$trip) {
            return redirect()->route('trip.index');
        }

        return view('journeyStages.create', compact('trip'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $trip_id)
    {
        //Form
        $data = $request->all();

        //Nuova istanza per la tappa JourneyStage
        $journeyStage = new JourneyStage();
        $journeyStage->nome = $data['nome'];
        $journeyStage->descrizione = $data['descrizione'];
        $journeyStage->posizione = $data['posizione'];
        $journeyStage->data = $data['data'];
        $journeyStage->ordine = $data['ordine'];
        $journeyStage->completata = isset($data['compleata']) ? 1 : 0;

        $journeyStage->trip_id = $trip_id;

        //Salvo
        $journeyStage->save();

        return redirect()->route('trip.show', $trip_id);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
