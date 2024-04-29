<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\api\ProduitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RestaurantController;
use App\Http\Controllers\api\QRCodeController;
use App\Http\Controllers\api\TableController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/restaurants', [RestaurantController::class, 'index']);

    Route::get('/user', function (Request $request) {return $request->user();
    });
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);
    Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);
    Route::post('/restaurants/{restaurant_id}/produits', [ProduitController::class, 'store']);
    Route::get('restaurants/{restaurant_id}/produits', [ProduitController::class, 'index']);
    Route::post('/restaurants/{restaurant_id}/tables', [TableController::class, 'store']);
    Route::get('/tables/{restaurant_id}', [TableController::class, 'show']);
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/qrcode', [QRCodeController::class, 'generate'])->name('qrcode.generate');
Route::post('/restaurants/{restaurant_id}/commandes', [CommandeController::class, 'store']);





