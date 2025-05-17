<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;


class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'contenido' => 'required|string',
        ]);

        Comentario::create([
            'contenido' => $request->contenido,
            'usuario_id' => auth::id(),
            'post_id' => $postId,
        ]);

        return redirect()->route('posts.show', $postId)->with('success', '¡Comentario agregado!');
    }
}
