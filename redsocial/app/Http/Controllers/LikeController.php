<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Notifications\NuevoLike;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($user->liked_posts->contains($post->id)) {
            $user->liked_posts()->detach($post->id);
        } else {
            $user->liked_posts()->attach($post->id);

            // Enviar notificación al autor del post (si no es él mismo)
            if ($post->usuario->id !== $user->id) {
                $post->usuario->notify(new NuevoLike($post, $user));

                // ✅ Emitimos el evento en tiempo real
                $notificacion = $post->usuario->notifications()->latest()->first();
                event(new \App\Events\NuevaNotificacion($notificacion, $post->usuario->id));
            }
        }

        return back();
    }
}
