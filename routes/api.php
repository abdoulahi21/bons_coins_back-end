<?php

use App\Http\Controllers\LieuController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//routes public
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

//routes protected
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user',[UserController::class,'index']);
    Route::post('/logout', [UserController::class, 'logout']);

    //place
    Route::post('/places', [LieuController::class, 'store']);


    Route::put('/places/{id}', [LieuController::class, 'update']);
    Route::delete('/places/{id}', [LieuController::class, 'destroy']);

    //opinions
    Route::post('/places/{id}/opinions', [OpinionController::class, 'store']);
    Route::get('/places/{id}/opinions', [OpinionController::class, 'index']);
    Route::get('/places/{id}/opinions/{idOpinion}', [OpinionController::class, 'show']);
    Route::put('/opinions/{id}', [OpinionController::class, 'update']);
    Route::delete('/opinions/{id}', [OpinionController::class, 'destroy']);
    //like
    Route::post('/places/{id}/likes', [LikeController::class, 'likeOrUnLike']);
});
Route::get('/places', [LieuController::class, 'index']);
Route::get('/places/{id}', [LieuController::class, 'show']);
