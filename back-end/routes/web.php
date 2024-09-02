<?php

use App\Http\Controllers\JourneyStagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Default Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //ROTTE DEI VIAGGI

    //Rotta INDEX TRIPS
    Route::get('/trips', [TripController::class, 'index'])->name('trip.index');

    //Rotta SHOW TRIPS
    Route::post('/trips/show', [TripController::class, 'show'])->name('trip.show');

    //Rotta CREATE TRIPS
    Route::get('/trips/create', [TripController::class, 'create'])->name('trip.create');

    //Rotta STORE TRIPS
    Route::post('/trips/create', [TripController::class, 'store'])->name('trip.store');

    //Rotta EDIT TRIPS
    Route::post('/trips/edit', [TripController::class, 'edit'])->name('trip.edit');

    //Rotta UPDATE TRIPS
    Route::put('/trips/edit', [TripController::class, 'update'])->name('trip.update');

    //Rotta DESTROY TRIPS
    Route::delete('/trips/delete', [TripController::class, 'destroy'])->name('trip.destroy');



    // PRG - POST REDIRECT GET

    //ROTTE DELLE TAPPE

    //Rotta INDEX TAPPE (Rotta d'appoggio)
    Route::get('/trips/index', [JourneyStagesController::class, 'ricevuta'])->name('returnTrip.index');

    //Rotta CREATE TAPPE
    Route::post('/trips/journey-stages/create', [JourneyStagesController::class, 'create'])->name('journeyStages.create');

    //Rotta STORE TAPPE
    Route::post('/trips/journey-stages', [JourneyStagesController::class, 'store'])->name('journeyStages.store');

    //Rotta EDIT TAPPE
    Route::post('/journey-stages/edit', [JourneyStagesController::class, 'edit'])->name('journeyStages.edit');

    // Rotta UPDATE TAPPE
    Route::put('/journey-stages/update', [JourneyStagesController::class, 'update'])->name('journeyStages.update');

    //Rotta DELETE TAPPE
    Route::delete('/journey-stages/delete', [JourneyStagesController::class, 'destroy'])->name('journeyStages.destroy');
});

require __DIR__ . '/auth.php';
