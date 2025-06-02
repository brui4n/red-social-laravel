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

    // Verifica que el usuario actual sea el autor del comentario
    private function authorizeUser(Comentario $comentario)
    {
        if (Auth::id() !== $comentario->usuario_id) {
            abort(403, 'No tienes permisos para modificar este comentario.');
        }
    }
}
