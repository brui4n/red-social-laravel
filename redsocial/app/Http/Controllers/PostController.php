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
        $imagenPath = null;
        $archivoPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes', 'public');
        }

        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('archivos', 'public');
        }



        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        Post::create([
            'usuario_id' => auth()->id(),
            'contenido' => $request->contenido,
            'imagen' => $imagenPath,
            'archivo' => $archivoPath,
            'codigo' => $request->codigo,
            'lenguaje' => $request->lenguaje,
        ]);

        return redirect()->route('posts.index')->with('success', '¡Post creado con éxito!');
    }

    public function show($id)
    {
        $post = Post::with('comentarios')->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
