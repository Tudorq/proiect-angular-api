<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Carbon;


class GameController extends Controller
{
    public function addGame(Request $request)
    {
        $validatedData = $request->validate([

            'user_id' => ['required'],
            'name' => ['required', 'max:255'],
            'publisher' => ['required'],
            'status' => ['required'],
            'rating' => ['required'],
            'completion_time' => ['required'],
            'started_at' => ['required'],
            'finished_at' => ['required']
        ]);
        
        $user_id = $validatedData['user_id'];
        $name = $validatedData['name'];
        $publisher = $validatedData['publisher'];
        $status = $validatedData['status'];
        $rating = $validatedData['rating'];
        $completion_time = $validatedData['completion_time'];
        $started_at = substr($validatedData['started_at'], 0, 10);
        $finished_at = substr($validatedData['finished_at'], 0, 10);

        $game = Game::Create(['user_id' => $user_id, 'name' => $name, 'publisher' => $publisher, 'status' => $status, 'rating' => $rating,
                            'completion_time' => $completion_time, 'started_at' => $started_at, 'finished_at' => $finished_at]);

        $game->save();

        return response()->json([
            'game' => $game,
        ], 200);
    }

    public function getGame(Request $request)
    {
        $gameId = $request->route()->parameter('id');
        $game = Game::firstWhere('id', $gameId);

        return response()->json([
            'game' => $game,
        ], 200);
    }

    public function getGames(Request $request)
    {
        $userId = $request->route()->parameter('id');
        // dd($userId);
        $games = Game::Where('user_id', $userId)->get();
        // dd($games);  

        return response()->json($games, 200);
    }

    public function changeGameStatus(Request $request)
    {
        $gameId = $request->route()->parameter('id');
        $game = Game::firstWhere('id', $gameId);

        $validatedData = $request->validate([

            'status' => ['required']
        ]);

        $game->status = $validatedData['status'];

        $game->save();

        return response()->json([
            'game' => $game,
        ], 200);
    }

    public function updateGame(Request $request)
    {
        $gameId = $request->route()->parameter('id');
        $game = Game::firstWhere('id', $gameId);

        $validatedData = $request->validate([

            'name' => ['required', 'max:255'],
            'publisher' => ['required'],
            'status' => ['required'],
            'rating' => ['required'],
            'completion_time' => ['required'],
            'started_at' => ['required'],
            'finished_at' => ['required']
        ]);
        
        // dd($game->started_at);

        $name = $validatedData['name'];
        $publisher = $validatedData['publisher'];
        $status = $validatedData['status'];
        $rating = $validatedData['rating'];
        $completion_time = $validatedData['completion_time'];
        $started_at = substr($validatedData['started_at'], 0, 10);
        $finished_at = substr($validatedData['finished_at'], 0, 10);

        $game->name = $name;
        $game->publisher = $publisher;
        $game->status = $status;
        $game->rating = $rating;
        $game->completion_time = $completion_time;
        $game->started_at = $started_at;
        $game->finished_at = $finished_at;

        $game->save();

        return response()->json([
            'game' => $game,
        ], 200);
    }

    public function deleteGame(Request $request)
    {
        $gameId = $request->route()->parameter('id');
        $game = Game::firstWhere('id', $gameId);
        $game->delete();

        return response()->json([
            'message' => 'Game deleted succesfully',
        ], 200);
    }
}
