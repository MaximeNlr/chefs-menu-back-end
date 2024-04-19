<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Http\Controllers\Api\RestaurantController;

// Route pour obtenir tous les restaurants
Route::get('/restaurants', [RestaurantController::class, 'index']);

// Route pour créer un nouveau restaurant
Route::post('/restaurants', [RestaurantController::class, 'store']);

// Route pour afficher un restaurant spécifique
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

// Route pour mettre à jour un restaurant
Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);

// Route pour supprimer un restaurant
Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);


// Route pour ajouter un nouvel élément à la carte du restaurant
Route::post('/restaurants/{restaurant_id}/elements', [RestaurantController::class, 'storeElement']);
