<?php

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

use App\Http\Controllers\CurrentGameController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;

Route::get('current-game', [CurrentGameController::class, 'show']);

Route::get('games', [GameController::class, 'index']);
Route::get('games/next-ones', [GameController::class, 'nextGames']);

Route::get('players', [PlayerController::class, 'index']);

Route::group(['middleware'=>'auth.verybasic'], function() {
    Route::put('current-game',[CurrentGameController::class, 'update']);

    Route::post('games', [GameController::class, 'create']);
    Route::put('games/{game}', [GameController::class, 'update']);

    Route::post('players', [PlayerController::class, 'create']);
    Route::put('players/{player}', [PlayerController::class, 'update']);
    Route::delete('players/{player}', [PlayerController::class, 'destroy']);
});
