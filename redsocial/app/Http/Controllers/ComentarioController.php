<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevoComentario;

class ComentarioController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        // Crear el comentario
        $comentario = Comentario::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        // Obtener el post y el usuario dueño del post
        $post = Post::findOrFail($postId);
        $autor = $post->usuario;

        // Si el usuario que comenta NO es el autor del post, le mandamos la notificación
        if ($autor && $autor->id !== Auth::id()) {
            $autor->notify(new NuevoComentario($comentario));
        }

        return redirect()->back()->with('toast', 'Comentario enviado y notificación enviada al autor del post.');

    }
    public function edit(Comentario $comentario)
    {
        $this->authorizeUser($comentario);

        return view('comentarios.edit', compact('comentario'));
    }

    public function update(Request $request, Comentario $comentario)
    {
        $this->authorizeUser($comentario);

        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        $comentario->update([
            'contenido' => $request->contenido,
        ]);

        return redirect()->back()->with('success', 'Comentario actualizado');
    }

    public function destroy(Comentario $comentario)
    {
        $this->authorizeUser($comentario);

        $comentario->delete();

        return redirect()->back()->with('success', 'Comentario eliminado');
    }

    // ✅ Verifica que el usuario actual sea el autor del comentario
    private function authorizeUser(Comentario $comentario)
    {
        if (Auth::id() !== $comentario->user_id) { // <- CAMBIO AQUÍ
            abort(403, 'No tienes permisos para modificar este comentario.');
        }
    }
}
