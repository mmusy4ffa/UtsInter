<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('bukus', BukuController::class);
Route::get('bukus/search', [BukuController::class, 'search']);


// Route::put('bukus/{id}', [BukuController::class, 'update']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


