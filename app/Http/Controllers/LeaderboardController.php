<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = User::select('users.id', 'users.name', DB::raw('COUNT(games.winner_id) as wins'))
            ->leftJoin('games', 'users.id', '=', 'games.winner_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('wins')
            ->limit(10)
            ->get();

        return view('leaderboard', compact('leaderboard'));
    }
}

