<?php

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

use App\Http\Controllers\FlushController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'index']);
Route::get('counter', [WebController::class, 'counter'])->name('counter');
Route::get('games', [WebController::class, 'games'])->name('games');

Route::group(['middleware' => 'auth.verybasic'], function() {
    Route::get('dashboard', [WebController::class, 'dashboard'])->name('dashboard');
    Route::post('/players/import',[PlayerController::class, 'import'])->name('players.import');
    Route::post('/flush',[FlushController::class,'flush'])->name('flush-all');
});

