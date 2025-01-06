@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold mb-4">Game #{{ $game->id }}</h1>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Game Details
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Current game information and board.
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ ucfirst($game->status) }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Player 1
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $game->player1->name }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Player 2
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $game->player2->name ?? 'Waiting for opponent' }}
                            </dd>
                        </div>
                        @if ($game->status === 'in_progress')
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Current Turn
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $game->current_turn }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($game->status === 'waiting' && $game->player1_id !== auth()->id())
                <form action="{{ route('games.join', $game) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Join Game
                    </button>
                </form>
            @endif

            @if ($game->status === 'in_progress')
                <div class="tictactoe-board mt-8">
                    @for ($i = 0; $i < 9; $i++)
                        <form action="{{ route('games.move', $game) }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="position" value="{{ $i }}">
                            <button type="submit" class="tictactoe-cell w-20 h-20 text-4xl font-bold flex items-center justify-center bg-gray-200 hover:bg-gray-300 {{ $game->board[$i] ? 'cursor-not-allowed' : 'cursor-pointer' }}" {{ $game->board[$i] ? 'disabled' : '' }}>
                                {{ $game->board[$i] ?? '' }}
                            </button>
                        </form>
                    @endfor
                </div>
            @endif

            @if ($game->status === 'finished')
                <div class="mt-4 text-center">
                    <p class="text-xl font-bold">
                        Winner: {{ $game->winner->name ?? 'Draw' }}
                    </p>
                </div>
            @endif

            <div class="mt-8">
                <p class="text-sm text-gray-500">
                    Share this game(This link expires in 24 hours):
                    <a href="{{ $inviteLink }}" class="text-indigo-600 hover:text-indigo-500">
                        {{ $inviteLink }}
                    </a>
                </p>
            </div>
        </div>
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
    </style>
@endpush
