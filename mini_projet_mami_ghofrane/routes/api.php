<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonneController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Préfixe automatique : /api
|--------------------------------------------------------------------------
*/

// Routes API pour les abonnés
Route::prefix('abonnes')->group(function () {

    // Routes spécifiques (AVANT {id})
    Route::get('/search', [AbonneController::class, 'search']);
    Route::get('/stats', [AbonneController::class, 'stats']);

    // CRUD REST
    Route::get('/', [AbonneController::class, 'index']);
    Route::post('/', [AbonneController::class, 'store']);
    Route::get('/{id}', [AbonneController::class, 'show']);
    Route::put('/{id}', [AbonneController::class, 'update']);
    Route::delete('/{id}', [AbonneController::class, 'destroy']);
});
