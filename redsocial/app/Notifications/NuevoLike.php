<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\User;
use App\Events\NuevaNotificacion;

class NuevoLike extends Notification
{
    use Queueable;

    protected $post;
    protected $user; // Usuario que dio el like

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {


        return [
            'mensaje' => '❤️ ' . $this->user->nombre . ' le dio like a tu post.',
            'post_id' => $this->post->id,
            'usuario_like' => $this->user->nombre,
        ];
    }
}
