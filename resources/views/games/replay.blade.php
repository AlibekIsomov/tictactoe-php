@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Replay Game #{{ $game->id }}</h1>
        <p>Player 1: {{ $game->player1->name }}</p>
        <p>Player 2: {{ $game->player2->name }}</p>

        <div class="tictactoe-board">
            @for ($i = 0; $i < 9; $i++)
                <button type="button" class="btn btn-outline-primary" disabled>&nbsp;</button>
            @endfor
        </div>

        <div class="mt-4">
            <button id="prevMove" class="btn btn-secondary">Previous Move</button>
            <button id="nextMove" class="btn btn-primary">Next Move</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const moves = @json($moves);
        let currentMove = -1;
        const board = document.querySelectorAll('.tictactoe-board button');
        const prevButton = document.getElementById('prevMove');
        const nextButton = document.getElementById('nextMove');

        function updateBoard() {
            for (let i = 0; i <= currentMove; i++) {
                const move = moves[i];
                board[move.position].textContent = i % 2 === 0 ? 'X' : 'O';
            }
            for (let i = currentMove + 1; i < 9; i++) {
                board[i].textContent = '\u00A0';
            }
            prevButton.disabled = currentMove === -1;
            nextButton.disabled = currentMove === moves.length - 1;
        }

        prevButton.addEventListener('click', () => {
            if (currentMove > -1) {
                currentMove--;
                updateBoard();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentMove < moves.length - 1) {
                currentMove++;
                updateBoard();
            }
        });

        updateBoard();
    </script>
@endpush

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

