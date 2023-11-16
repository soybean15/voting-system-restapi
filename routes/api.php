<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::resource('/candidate', \App\Http\Controllers\CandidateController::class);
Route::get('/candidates',[\App\Http\Controllers\CandidateController::class, 'getCandidates'])->name('candidate.getCandidates');
Route::post('/candidates/position/{id}/insert',[\App\Http\Controllers\CandidateController::class, 'insertCandidates'])->name('candidate.insertCandidate');
Route::delete('/candidate/position/{id}/remove',[\App\Http\Controllers\CandidateController::class, 'removeCandidatePosition'])->name('candidate.removeCandidatePosition');
Route::get('/candidate/position/{id}', [\App\Http\Controllers\CandidateController::class, 'createCandidate'])->name('candidate.create_candidate');
Route::put('/candidate/position/{id}/edit', [\App\Http\Controllers\CandidateController::class, 'editPosition'])->name('candidate.edit_position');
Route::post('/candidate/add', [\App\Http\Controllers\CandidateController::class, 'storeCandidate'])->name('candidate.store_candidate');
Route::post('/candidate/position/{id}', [\App\Http\Controllers\CandidateController::class, 'updatePosition'])->name('candidate.update_position');
Route::delete('/candidate/position/{id}', [\App\Http\Controllers\CandidateController::class, 'destroyPosition'])->name('candidate.destroy_position');
Route::resource('/partylist', \App\Http\Controllers\PartyListController::class);

Route::get('/voting',[\App\Http\Controllers\VotingController::class, 'index'])->name('voting.index')->middleware('hasVoted');
Route::get('/voting/check',[\App\Http\Controllers\VotingController::class, 'check'])->name('voting.check');
Route::post('/voting',[\App\Http\Controllers\VotingController::class, 'store'])->name('voting.store');
//Route::post('/partylist/{id}', [\App\Http\Controllers\PartyListController::class, 'update'])->name('partylist.update');
Route::get('voting/result','\App\Http\Controllers\VotingController@getResult');
Route::get('voting/settings','\App\Http\Controllers\VotingController@getSettings');

Route::get('/dashboard','\App\Http\Controllers\AdminController@dashboard');

Route::get('/admin','\App\Http\Controllers\AdminController@index');
Route::get('admin/settings','\App\Http\Controllers\AdminController@getSettings');
Route::post('admin/settings/show-result','\App\Http\Controllers\AdminController@handleShowResult');
Route::post('admin/settings/open-voting','\App\Http\Controllers\AdminController@openVoting');

Route::get('admin/result','\App\Http\Controllers\AdminController@getResult');

Route::get('/download-result',[AdminController::class,'printResult']);


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
})->middleware('verified');
