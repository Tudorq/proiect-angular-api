<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;





Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::delete('/delete/{id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
Route::get('/user/{id}', [UserController::class, 'getUser'])->middleware('auth:sanctum');
Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::get('/game/{id}', [GameController::class, 'getGame'])->middleware('auth:sanctum');
Route::get('/games/{id}', [GameController::class, 'getGames']);
Route::post('/game/addGame', [GameController::class, 'addGame']);
Route::post('/game/changeStatus/{id}', [GameController::class, 'changeGameStatus'])->middleware('auth:sanctum');
Route::post('/game/update/{id}', [GameController::class, 'updateGame']);
Route::delete('/game/delete/{id}', [GameController::class, 'deleteGame']);







Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
