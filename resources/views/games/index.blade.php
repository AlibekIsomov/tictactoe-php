@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Games</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Game ID</th>
                <th>Opponent</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>
                        @if ($game->player1_id === auth()->id())
                            {{ $game->player2->name ?? 'Waiting for opponent' }}
                        @else
                            {{ $game->player1->name }}
                        @endif
                    </td>
                    <td>{{ ucfirst($game->status) }}</td>
                    <td>
                        <a href="{{ route('games.show', $game) }}" class="btn btn-sm btn-primary">View</a>
                        @if ($game->status === 'finished')
                            <a href="{{ route('games.replay', $game) }}" class="btn btn-sm btn-secondary">Replay</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $games->links() }}
    </div>
@endsection

