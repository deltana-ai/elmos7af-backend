<?php


use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrentPositionController;
use App\Http\Controllers\DailyStatisticController;
use App\Http\Controllers\KhatmahController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/notes/store', [NoteController::class, 'store']);
Route::put('/notes/update/{id}', [NoteController::class, 'update']);
Route::get('/notes/{uuid}', [NoteController::class, 'getNotesByUuid']);

Route::post('/khatmah/store', [KhatmahController::class, 'store']);
Route::put('/khatmah/update', [KhatmahController::class, 'update']);
Route::get('/khatmah/{uuid}', [KhatmahController::class, 'getKhatmahByUuid']);



Route::post('/statistics/store', [DailyStatisticController::class, 'store']);
Route::put('/statistics/update', [DailyStatisticController::class, 'update']);


Route::post('/position/save', [CurrentPositionController::class, 'storeOrUpdate']);
