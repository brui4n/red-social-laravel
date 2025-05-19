<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        Comentario::create([
            'post_id' => $postId,
            'usuario_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        return redirect()->back()->with('success', 'Comentario publicado');
    }
}
