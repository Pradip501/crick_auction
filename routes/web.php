<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\PlayersController;
use App\Http\Controllers\Backend\TeamsController;
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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // xss protection
    Route::group(['middleware' => 'XSS'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        // Teams Controller
        Route::get('/teams', [TeamsController::class, 'index'])->name('teams');
        Route::get('/team/add', [TeamsController::class, 'create'])->name('team.create');
        Route::post('/team/store', [TeamsController::class, 'storeteam'])->name('teams.store');
        Route::get('/team/edit/{id}', [TeamsController::class, 'editteam'])->name('team.edit');
        Route::put('/team/update/{id}', [TeamsController::class, 'updateteam'])->name('teams.update');
        Route::delete('/team/delete/{id}', [TeamsController::class, 'deleteteam'])->name('team.delete');
        
        // Players Controller
        Route::get('/players', [PlayersController::class, 'index'])->name('players');
        Route::get('/player/add', [PlayersController::class, 'create'])->name('player.create');
        Route::post('/player/store', [PlayersController::class, 'storePlayer'])->name('players.store');
        Route::get('/player/edit/{id}', [PlayersController::class, 'editPlayer'])->name('player.edit');
        Route::put('/player/update/{id}', [PlayersController::class, 'updatePlayer'])->name('players.update');
        
        Route::get('/player/view/{id}', [PlayersController::class, 'viewPlayer'])->name('player.view');
        Route::post('/players/update-info', [PlayersController::class, 'updatePlayerInfo'])->name('players.updatePlayerInfo');
        Route::delete('/player/delete/{id}', [PlayersController::class, 'deletePlayer'])->name('player.delete');
        
        // team players
        Route::get('/team-players', [PlayersController::class, 'teamPlayers'])->name('team.players');


    });
});

