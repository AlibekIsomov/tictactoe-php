@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex flex-col items-center justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Welcome to TicTacToe
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Play the classic game with friends online!
                    </p>
                </div>
                <div class="mt-8 space-y-6">
                    @guest
                        <div>
                            <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Login
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('register') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Register
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('games.create') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Start New Game
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('games.index') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                My Games
                            </a>
                        </div>
                    @endguest
                    <div>
                        <a href="{{ route('leaderboard') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            View Leaderboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

