<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JourneyStage;
use Illuminate\Http\Request;

class JourneyStagesApiController extends Controller
{
    public function index()
    {
        $stage = JourneyStage::all();

        return response()->json($stage);
    }
}
