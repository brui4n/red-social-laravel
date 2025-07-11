<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\Tag;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Página de bienvenida (welcome)
Route::get('/', function () {
    return view('welcome');
})->name('home');


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

    // Página de inicio con Filtro por Etiquetas
    Route::get('/inicio', function (\Illuminate\Http\Request $request) {
        $query = Post::with(['user', 'tags']);

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }


        $posts = $query->latest()->get();
        $tags = Tag::all();

        return view('inicio', compact('posts', 'tags'));
    })->name('inicio');

    // Dashboard de Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // CRUD de perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{user}/toggle-follow', [ProfileController::class, 'toggleFollow'])->name('profile.toggle-follow');

    // CRUD de posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Ver mis posts
    Route::get('/mis-posts', [PostController::class, 'misPosts'])->name('posts.mis_posts');

    //Ver mis comentarios
    Route::get('/mis-comentarios', [ProfileController::class, 'misComentarios'])->name('mis.comentarios');

    //Ver mis "me gusta"
    Route::get('/posts-que-me-gustaron', [ProfileController::class, 'postsQueMeGustaron'])->name('posts.que_me_gustaron');


    // Comentarios
    Route::post('/posts/{post}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::get('/comentarios/{comentario}/editar', [ComentarioController::class, 'edit'])->name('comentarios.edit');
    Route::put('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

    // Visualizar todas las notificaciones

    Route::get('/notificaciones', function () {
        $notificaciones = auth()->user()->notifications()->latest()->paginate(10);
        return view('notificaciones.index', compact('notificaciones'));
    })->name('notificaciones.index');


    // Marcar notificaciones como leidas

    Route::post('/notificaciones/marcar-leidas', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notificaciones.marcarLeidas');

    // Eliminar notificaciones 

    Route::delete('/notificaciones/{id}', function ($id) {
        $notificacion = auth()->user()->notifications()->findOrFail($id);
        $notificacion->delete();
        return back();
    })->name('notificaciones.eliminar');


});



/*
|--------------------------------------------------------------------------
| Rutas generadas por Breeze automáticamente
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
