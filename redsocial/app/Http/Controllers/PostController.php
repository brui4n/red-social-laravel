<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        ]);

        Post::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'usuario_id' => auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', '¡Post creado con éxito!');
    }

    public function show($id)
    {
        $post = Post::with('comentarios')->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
