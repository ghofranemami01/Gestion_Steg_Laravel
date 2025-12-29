
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonneController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Page d'accueil
Route::get('/', function () {
    return redirect('/abonnes/liste');
});

// Routes pour les abonnés
Route::prefix('abonnes')->group(function () {
    // Liste des abonnés (interface Vue.js)
    Route::get('/liste', function () {
        return view('abonnes.liste');
    })->name('abonnes.liste');

    // Vue traditionnelle pour la liste des abonnés
    Route::get('/', [AbonneController::class, 'webIndex'])->name('abonnes.index');
    Route::get('/create', [AbonneController::class, 'webCreate'])->name('abonnes.create');
    Route::post('/', [AbonneController::class, 'webStore'])->name('abonnes.store');
    Route::get('/{id}', [AbonneController::class, 'webShow'])->name('abonnes.show');
    Route::get('/{id}/edit', [AbonneController::class, 'webEdit'])->name('abonnes.edit');
    Route::put('/{id}', [AbonneController::class, 'webUpdate'])->name('abonnes.update');
    Route::delete('/{id}', [AbonneController::class, 'webDestroy'])->name('abonnes.destroy');
});
