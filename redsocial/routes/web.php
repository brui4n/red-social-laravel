<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación (login, registro, logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta principal (puedes ponerla pública o privada)
Route::get('/', function () {
    return view('welcome');
})->name('home');

//Ruta de inicio tras loguearse 
Route::get('/inicio', function () {
    return view('inicio');
})->middleware('auth')->name('inicio'); //nadie puede ingresar a la URL sin estar logueado

// Rutas protegidas solo para usuarios autenticados
Route::middleware(['auth'])->group(function () {



    // Aquí otras rutas protegidas que tengas (settings, perfil, etc)
});