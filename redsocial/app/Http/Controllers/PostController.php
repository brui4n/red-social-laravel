<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('tags');

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->tag);
            });
        }

        $posts = $query->latest()->paginate(10);
        $tags = Tag::all();

        return view('posts.index', compact('posts', 'tags'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
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


        // Sincronizar etiquetas (De deivid)
        $post->tags()->sync($request->tags ?? []);
    
        return redirect()->route('inicio')->with('success', '¡Post creado con éxito! 🎉');
    }


    public function show($id)
    {
        $post = Post::with(['comentarios.user', 'users_liked', 'tags'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este post.');
        }

        $tags = Tag::all();
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'tags', 'selectedTags'));
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
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
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

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

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

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('posts.mis_posts')->with('success', '¡Post eliminado correctamente!');
    }
}
