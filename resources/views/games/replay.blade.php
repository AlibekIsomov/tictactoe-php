@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Replay Game #{{ $game->id }}</h1>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-600">Player 1: {{ $game->player1->name }}</p>
                <p class="text-sm text-gray-600">Player 2: {{ $game->player2->name }}</p>
            </div>

            <div class="tictactoe-board mb-4">
                @for ($i = 0; $i < 9; $i++)
                    <button type="button" class="tictactoe-cell" disabled>&nbsp;</button>
                @endfor
            </div>

            <div class="mt-4 flex justify-center space-x-4">
                <button id="prevMove" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    Previous Move
                </button>
                <button id="nextMove" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                    Next Move
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const moves = @json($moves);
        let currentMove = -1;
        const board = document.querySelectorAll('.tictactoe-cell');
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

