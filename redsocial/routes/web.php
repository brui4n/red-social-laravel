<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Página de bienvenida (welcome)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Login y registro personalizados (de tu AuthController anterior)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Mostrar perfil público
Route::get('/perfil/{user}', [ProfileController::class, 'show'])->name('profile.show');
// Ver seguidores y seguidos públicamente
Route::get('/perfil/{user}/seguidores', [ProfileController::class, 'seguidores'])->name('profile.seguidores');
Route::get('/perfil/{user}/siguiendo', [ProfileController::class, 'siguiendo'])->name('profile.siguiendo');
/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Página de inicio tras iniciar sesión
    Route::get('/inicio', function () {
        $posts = Post::with('usuario')->latest()->get();
        return view('inicio', compact('posts'));
    })->name('inicio');

    // Dashboard de Breeze (puedes ignorarlo si no lo usarás)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // CRUD de perfil (agregado por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{user}/toggle-follow', [ProfileController::class, 'toggleFollow'])->name('profile.toggle-follow');

    // CRUD de posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Ver mis posts
    Route::get('/mis-posts', [PostController::class, 'misPosts'])->name('posts.mis_posts');

    // Comentarios
    Route::post('/posts/{post}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::get('/comentarios/{comentario}/editar', [ComentarioController::class, 'edit'])->name('comentarios.edit');
    Route::put('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
});

/*
|--------------------------------------------------------------------------
| Rutas generadas por Breeze automáticamente
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
