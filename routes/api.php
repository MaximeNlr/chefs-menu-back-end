<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);




