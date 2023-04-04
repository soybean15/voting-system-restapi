<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
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
Route::get('/', function () {
    return view('homepage');
});
// Route::resource('candidate', CandidateController::class);

// Route::resource('candidate', CandidateController::class);
// Route::post('candidate/store',  [CandidateController::class,'storeCandidate'])->name('candidate.store');
Route::middleware(['cors'])->group(function () {
    Route::resource('candidate', CandidateController::class);

  //  Route::resource('candidate', CandidateController::class);
    Route::post('candidate/store',  [CandidateController::class,'storeCandidate'])->name('candidate.store');
    Route::get('candidate/position/{id}/add',[CandidateController::class,'createCandidate'])->name('candidate.add');
    Route::get('candidate/update',  [CandidateController::class,'update'])->name('candidate.update');


});