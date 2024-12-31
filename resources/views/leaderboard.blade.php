@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Leaderboard</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Rank</th>
                <th>Player</th>
                <th>Wins</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($leaderboard as $index => $player)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->wins }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

