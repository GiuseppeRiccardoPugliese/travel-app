<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;


class TripApiController extends Controller
{
    public function index()
    {
        $trips = Trip::with('users')->get();

        return response()->json($trips);
    }
}
