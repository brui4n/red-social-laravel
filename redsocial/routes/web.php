<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AuthController;
use App\Models\Post;



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
    $posts = Post::with('usuario')->latest()->get();
    return view('inicio', compact('posts'));
})->middleware('auth')->name('inicio');

// Rutas protegidas para posts
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

//Ruta para la creacion de un post

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');






// Rutas protegidas solo para usuarios autenticados
Route::middleware(['auth'])->group(function () {



    // Aquí otras rutas protegidas que tengas (settings, perfil, etc)
});