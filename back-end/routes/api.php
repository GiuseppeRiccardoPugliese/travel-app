<?php

use App\Http\Controllers\Api\JourneyStagesApiController;
use App\Http\Controllers\Api\TripApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {


    Route::post('/favorites-journey-stages', [JourneyStagesApiController::class, 'getTopRatedStages']);

    //ROTTA API VIAGGI
    Route::get('/trips', [TripApiController::class, 'index']);

    //ROTTA API TAPPE
    Route::get('/journey-stages', [JourneyStagesApiController::class, 'index']);

    //Rotta api per prendere le tappe con id specifico
    Route::get('/journey-stages-by-trip', [JourneyStagesApiController::class, 'getStagesByTripId']);

});
