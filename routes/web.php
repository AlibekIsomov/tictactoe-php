<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
    Route::post('/games/{game}/join', [GameController::class, 'join'])->name('games.join');
    Route::post('/games/{game}/move', [GameController::class, 'move'])->name('games.move');
    Route::get('/games/{game}/replay', [GameController::class, 'replay'])->name('games.replay');
    Route::get('/games/invite/{token}', [GameController::class, 'invite'])->name('games.invite');
});

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

