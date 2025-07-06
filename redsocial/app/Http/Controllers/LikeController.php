<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Notifications\NuevoLike;
use App\Models\User;

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
            if ($post->user->id !== $user->id) {
                $post->user->notify(new NuevoLike($post, $user));

                // ✅ Emitimos el evento en tiempo real
                $notificacion = $post->user->notifications()->latest()->first();
                event(new \App\Events\NuevaNotificacion($notificacion, $post->user->id));
            }
        }

        return back();
    }
}
