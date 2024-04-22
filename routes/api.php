<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RestaurantController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('logout',[AuthController::class,'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);




