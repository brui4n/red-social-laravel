<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'archivo' => 'nullable|file|max:5120',
            'codigo' => 'nullable|string',
            'lenguaje' => 'nullable|string|max:50',
        ]);

        $imagenPath = $request->hasFile('imagen')
            ? $request->file('imagen')->store('imagenes', 'public')
            : null;

        $archivoPath = $request->hasFile('archivo')
            ? $request->file('archivo')->store('archivos', 'public')
            : null;

        $post = Post::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'contenido' => $request->input('contenido'),
            'imagen' => $imagenPath,
            'archivo' => $archivoPath,
            'codigo' => $request->input('codigo'),
            'lenguaje' => $request->input('lenguaje'),
        ]);

        return redirect()->route('inicio')->with('success', '¡Post creado con éxito! 🎉');
    }

    public function show($id)
    {
        $post = Post::with(['comentarios.user', 'users_liked'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar este post.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        $imagenPath = $post->imagen;
        $archivoPath = $post->archivo;

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
        }

        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('archivos', 'public');
        }

        $post->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'imagen' => $imagenPath,
            'archivo' => $archivoPath,
            'codigo' => $request->codigo,
            'lenguaje' => $request->lenguaje,
        ]);

        return redirect()->route('inicio')->with('success', '¡Post actualizado!');
    }

    public function misPosts()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return view('posts.mis_posts', compact('posts'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar este post.');
        }

        if ($post->imagen) {
            \Storage::disk('public')->delete($post->imagen);
        }
        if ($post->archivo) {
            \Storage::disk('public')->delete($post->archivo);
        }

        $post->delete();

        return redirect()->route('posts.mis_posts')->with('success', '¡Post eliminado correctamente!');
    }
}
