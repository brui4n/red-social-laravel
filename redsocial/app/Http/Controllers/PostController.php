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
        // Validaciones
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|max:2048', // Máx 2MB
            'archivo' => 'nullable|file|max:5120', // Máx 5MB
            'codigo' => 'nullable|string',
            'lenguaje' => 'nullable|string|max:50',
        ]);

        // Guardar imagen si se sube
        $imagenPath = $request->hasFile('imagen')
            ? $request->file('imagen')->store('imagenes', 'public')
            : null;

        // Guardar archivo si se sube
        $archivoPath = $request->hasFile('archivo')
            ? $request->file('archivo')->store('archivos', 'public')
            : null;

        // Crear el post
        Post::create([
            'usuario_id' => Auth::id(),
            'titulo' => $request->titulo, // <-- ESTE FALTABA
            'contenido' => $request->input('contenido'),
            'imagen' => $imagenPath,
            'archivo' => $archivoPath,
            'codigo' => $request->input('codigo'),
            'lenguaje' => $request->input('lenguaje'),
        ]);

        return redirect()->route('home')->with('success', '¡Post creado con éxito! 🎉');
    }

    public function show($id)
    {
        $post = Post::with('comentarios')->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
