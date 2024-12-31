<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $games = auth()->user()->games()->latest()->paginate(10);
        return view('games.index', compact('games'));
    }

    public function create()
    {
        $game = $this->gameService->createGame(auth()->user());
        return redirect()->route('games.show', $game);
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function join(Game $game)
    {
        try {
            $this->gameService->joinGame($game, auth()->user());
            return redirect()->route('games.show', $game);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function move(Request $request, Game $game)
    {
        $request->validate(['position' => 'required|integer|min:0|max:8']);

        try {
            $this->gameService->makeMove($game, auth()->user(), $request->position);
            return redirect()->route('games.show', $game);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function replay(Game $game)
    {
        $moves = $game->moves()->orderBy('created_at')->get();
        return view('games.replay', compact('game', 'moves'));
    }
}

