<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::post('/register', [RegisteredUserController::class, 'storeApi'])
    ->name('api.register');
Route::post('/login', [AuthenticatedSessionController::class, 'storeApi'])->name('api.login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('/')->group(function (Illuminate\Routing\Router $route){
    $route->apiResource('reviews', \App\Http\Controllers\ReviewController::class, ['only' => ['index', 'show', 'store']])->where(['review' => '\d+']);
    $route->post('reviews/{id}', [\App\Http\Controllers\ReviewController::class, 'storeAnswer'])->where('id', '\d+');
});
