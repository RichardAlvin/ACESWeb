<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/user', UserController::class)->except(['create', 'edit', 'store']);
});

// Route::get('/user', [UserController::class, 'index']);
// Route::post('/user', [UserController::class, 'store']);
// Route::get('/user/{id}', [UserController::class, 'show']);
// Route::put('/user/{id}', [UserController::class, 'update']);
// Route::delete('/user/{id}', [UserController::class, 'destroy']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('/regis', [AuthController::class, 'regis']);
Route::post('/logout', [AuthController::class, 'logout']);
