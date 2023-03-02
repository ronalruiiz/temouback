<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register',[ \App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [ \App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('/therapy', \App\Http\Controllers\TherapyController::class,['except' => ['index', 'show']]);
});


Route::resource('/therapy', \App\Http\Controllers\TherapyController::class, ['only' => ['index', 'show']]);

//Exams
Route::get('/exam/{user}', [\App\Http\Controllers\ExamController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/exam', [ \App\Http\Controllers\ExamController::class, 'store']);

Route::get('/users-exams', [\App\Http\Controllers\ExamController::class, 'usersExam'])->middleware(['auth:sanctum']);
Route::get('/all-users', [\App\Http\Controllers\ExamController::class, 'allUsers'])->middleware(['auth:sanctum']);

