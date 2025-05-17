<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');



    

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    // Ruta para crear un post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Ruta para ver un post específico (y sus comentarios)
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

    // Ruta para guardar un comentario en un post
    Route::post('/posts/{id}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');





    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
