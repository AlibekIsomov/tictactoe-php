<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Move;
use App\Models\User;

class GameService
{
    public function createGame(User $player1): Game
    {
        return Game::create([
            'player1_id' => $player1->id,
            'status' => 'waiting',
            'board' => array_fill(0, 9, null),
            'current_turn' => 'X',
        ]);
    }

        public function joinGame(Game $game, User $player2): Game
    {
        if ($game->status !== 'waiting' || $game->player2_id !== null) {
            throw new \Exception('Game is not available to join.');
        }

        $game->update([
            'player2_id' => $player2->id,
            'status' => 'in_progress',
        ]);

        return $game;
    }

    public function makeMove(Game $game, User $player, int $position): Game
    {
        if ($game->status !== 'in_progress') {
            throw new \Exception('Game is not in progress.');
        }

        if ($game->current_turn === 'X' && $game->player1_id !== $player->id) {
            throw new \Exception('It\'s not your turn.');
        }

        if ($game->current_turn === 'O' && $game->player2_id !== $player->id) {
            throw new \Exception('It\'s not your turn.');
        }

        if ($game->board[$position] !== null) {
            throw new \Exception('This position is already taken.');
        }

        $board = $game->board;
        $board[$position] = $game->current_turn;
        $game->board = $board;
        $game->current_turn = $game->current_turn === 'X' ? 'O' : 'X';
        $game->save();

        Move::create([
            'game_id' => $game->id,
            'user_id' => $player->id,
            'position' => $position,
        ]);

        $winner = $this->checkWinner($game->board);
        if ($winner) {
            $game->update([
                'status' => 'finished',
                'winner_id' => $winner === 'X' ? $game->player1_id : $game->player2_id,
            ]);
        } elseif (!in_array(null, $game->board)) {
            $game->update(['status' => 'finished']);
        }

        return $game->fresh();
    }

    private function checkWinner(array $board): ?string
    {
        $winningCombinations = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
            [0, 4, 8], [2, 4, 6] // Diagonals
        ];

        foreach ($winningCombinations as $combination) {
            $line = array_map(fn($index) => $board[$index], $combination);
            if (count(array_unique($line)) === 1 && $line[0] !== null) {
                return $line[0];
            }
        }

        return null;
    }
}

