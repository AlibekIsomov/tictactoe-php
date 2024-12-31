@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Game #{{ $game->id }}</h1>
        <p>Status: {{ ucfirst($game->status) }}</p>
        <p>Player 1: {{ $game->player1->name }}</p>
        <p>Player 2: {{ $game->player2->name ?? 'Waiting for opponent' }}</p>

        @if ($game->status === 'waiting' && $game->player1_id !== auth()->id())
            <form action="{{ route('games.join', $game) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Join Game</button>
            </form>
        @endif

        @if ($game->status === 'in_progress')
            <p>Current Turn: {{ $game->current_turn }}</p>
            <div class="tictactoe-board">
                @for ($i = 0; $i < 9; $i++)
                    <form action="{{ route('games.move', $game) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="position" value="{{ $i }}">
                        <button type="submit" class="btn btn-outline-primary" {{ $game->board[$i] ? 'disabled' : '' }}>
                            {{ $game->board[$i] ?? '&nbsp;' }}
                        </button>
                    </form>
                @endfor
            </div>
        @endif

        @if ($game->status === 'finished')
            <p>Winner: {{ $game->winner->name ?? 'Draw' }}</p>
        @endif

        <p>Share this game: <a href="{{ route('games.show', $game) }}">{{ route('games.show', $game) }}</a></p>
    </div>
@endsection

@push('styles')
    <style>
        .tictactoe-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            width: 300px;
            margin: 20px auto;
        }
        .tictactoe-board button {
            height: 100px;
            font-size: 2em;
        }
    </style>
@endpush

