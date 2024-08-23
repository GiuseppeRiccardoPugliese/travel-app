<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JourneyStage;
use App\Models\Trip;

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
        return view('journeyStages.index', compact('trip', 'stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
