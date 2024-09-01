<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourneyStage;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JourneyStagesApiController extends Controller
{
    public function index()
    {
        $stage = JourneyStage::all();

        return response()->json($stage);
    }
    public function getTopRatedStages(Request $request)
    {
        $userId = $request->user_id;

        // Trovo tutti i viaggi associati all'utente
        $journeys = Trip::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Stage dei viaggi dell'utente
        $stages = JourneyStage::with('trip') // Carica anche il trip associato
            ->whereIn('trip_id', $journeys->pluck('id'))
            ->get();

        // Media di tutte le votazioni delle tappe
        $averageRating = $stages->avg('votazione');
        // dd($averageRating);

        // Tappe con votazione superiore alla media
        $aboveAverageStages = $stages->filter(function ($stage) use ($averageRating) {
            return $stage->votazione >= $averageRating;
        });

        // Tappe con votazione superiore alla media come JSON
        return response()->json($aboveAverageStages);
    }

    //Func per le tappe con id specifico nel front
    public function getStagesByTripId(Request $request)
    {
        $tripId = $request->query('trip_id');

        // Tappe per il viaggio specificato
        $stages = JourneyStage::where('trip_id', $tripId)->get();

        return response()->json($stages);
    }
}
