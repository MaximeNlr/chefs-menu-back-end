<?php

use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Qrcode\QRCodeController;
use App\Http\Controllers\Commande\CommandeController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/showRestaurant/{id}', [RestaurantController::class, 'showRestaurant'])->name('showRestaurant');
Route::post('/restaurants/{restaurant_id}/elements', [RestaurantController::class, 'storeElement'])->name('element.store');


Route::get('/qrcode', [QRCodeController::class, 'generate'])->name('qrcode.generate');


Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');





