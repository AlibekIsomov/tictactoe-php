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

//    public function show(Game $game)
//    {
//        return view('games.show', compact('game'));
//    }

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
        // Validate the position input
        $request->validate(['position' => 'required|integer|min:0|max:8']);

        try {
            // Attempt to make the move using the game service
            $updatedGame = $this->gameService->makeMove($game, auth()->user(), $request->position);
            return redirect()->route('games.show', $updatedGame);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function replay(Game $game)
    {
        $moves = $game->moves()->orderBy('created_at')->get();

        // Debugging to check the data being retrieved
        if ($moves->isEmpty()) {
            dd('No moves found for this game:', $game->id);
        }

        return view('games.replay', compact('game', 'moves'));
    }

    public function invite($token)
    {
        // Decode the token
        $decodedToken = json_decode(base64_decode($token), true);

        // Check if the token is valid
        if ($decodedToken && $decodedToken['expires_at'] > now()->timestamp) {
            // Find the game by ID
            $game = Game::find($decodedToken['game_id']);

            if ($game) {
                // Redirect to the game show page or handle the invitation logic
                return redirect()->route('games.show', $game);
            } else {
                return redirect()->route('home')->withErrors(['error' => 'Game not found.']);
            }
        } else {
            return redirect()->route('home')->withErrors(['error' => 'Invalid or expired invitation link.']);
        }
    }

    public function show(Game $game)
    {
        // Generate expiration timestamp (24 hours from now)
        $expiration = now()->addHours(24)->timestamp;

        // Create a token with game ID and expiration timestamp
        $token = base64_encode(json_encode([
            'game_id' => $game->id,
            'expires_at' => $expiration,
        ]));

        // Generate the invite link
        $inviteLink = route('games.invite', ['token' => $token]);

        // Pass the invite link to the view
        return view('games.show', compact('game', 'inviteLink'));
    }
}
