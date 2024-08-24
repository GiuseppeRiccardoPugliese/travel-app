<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JourneyStage;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;


//CODICE 1 == CREAZIONE TAPPA
//CODICE 2 == MODIFICA TAPPA
//CODICE 3 == ELIMINAZIONE TAPPA

class JourneyStagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Recupero il viaggio specifico
        $trip = Trip::findOrFail($request->input('trip'));

        // Recupero gli stages relativi a quel viaggio
        $stages = $trip->journeyStages;

        // Passo i dati alla vista
        return view('trips.show', compact('trip', 'stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Trovo il viaggio e verifico che appartenga all'utente autenticato
        $trip = Trip::find($request->trip_id);

        return view('journeyStages.create', compact('trip'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $trip_id = $request->trip_id;

        $journeyStage->trip_id = $trip_id;

        //Salvo
        $journeyStage->save();

        $trip = Trip::find($request->trip_id);

        // Reindirizzo alla pagina show del viaggio DOPO aver mostrato il messaggio di Creazione con la pagina di Appoggio INDEX
        $codice = 1;

        return view('journeyStages.index', compact('trip', 'codice'));


        // Reindirizza alla pagina di supporto temporaneo che eseguirà il POST
        // return redirect()->route('returnTrip.index')
        //     ->with(['trip' => $trip, 'codice' => $codice]);

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
    public function edit(Request $request)
    {
        $stage = JourneyStage::findOrFail($request->stage_id);
        $trip = Trip::findOrFail($request->trip_id);

        return view('journeyStages.edit', compact('stage', 'trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $stage = JourneyStage::findOrFail($request->stage_id);

        // Viaggio associato alla tappa dell'utente
        $trip = Trip::findOrFail($request->trip_id);

        $stage->nome = $request->input('nome');
        $stage->descrizione = $request->input('descrizione');
        $stage->posizione = $request->input('posizione');
        $stage->data = $request->input('data');
        $stage->ordine = $request->input('ordine');

        // dd($request->input('completata'));
        $stage->completata = $request->input('completata') == null ? '0' : '1';

        // Salvo 
        $stage->save();

        // Reindirizzo alla pagina show del viaggio DOPO aver mostrato il messaggio di Modifica con la pagina di Appoggio INDEX
        $codice = 2;
        return view('journeyStages.index', compact('trip', 'codice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $trip_id = $request->trip_id;
        $stage = JourneyStage::findOrFail($request->stage_id);

        $stage->trip()->dissociate();
        $trip = Trip::find($trip_id);

        $stage->delete();

        // Reindirizzo alla pagina show del viaggio DOPO aver mostrato il messaggio di Eliminazione con la pagina di Appoggio INDEX
        $codice = 3;
        return view('journeyStages.index', compact('trip', 'codice'));
    }
}
