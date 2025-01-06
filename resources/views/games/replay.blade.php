<!DOCTYPE html>
<html>
<head>
    <title>Tic Tac Toe Replay</title>
    <style>
        .tictactoe-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            width: 300px;
            margin: 0 auto;
        }
        .tictactoe-cell {
            aspect-ratio: 1;
            background: #f3f4f6;
            border: 2px solid #d1d5db;
            font-size: 2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="tictactoe-board">
    @for ($i = 0; $i < 9; $i++)
        <div class="tictactoe-cell" data-position="{{ $i }}"></div>
    @endfor
</div>

<button id="prevMove">Previous Move</button>
<button id="nextMove">Next Move</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const moves = @json($moves);
        let currentMove = -1;
        const board = document.querySelectorAll('.tictactoe-cell');
        const prevButton = document.getElementById('prevMove');
        const nextButton = document.getElementById('nextMove');

        function updateBoard() {
            // Reset all cells
            board.forEach(cell => {
                cell.textContent = '';
                cell.style.backgroundColor = '#f3f4f6';
            });

            // Apply moves up to current position
            for (let i = 0; i <= currentMove; i++) {
                const move = moves[i];
                const cell = board[move.position];
                const symbol = move.user_id === {{ $game->player1_id }} ? 'X' : 'O';
                cell.textContent = symbol;

                // Highlight the latest move
                if (i === currentMove) {
                    cell.style.backgroundColor = '#e5e7eb';
                }
            }

            // Update button states
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

        // Initialize board
        updateBoard();
    });
</script>
</body>
</html>
