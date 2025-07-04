<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Comentario;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NuevoComentario extends Notification
{
    use Queueable;

    public $comentario;

    public function __construct(Comentario $comentario)
    {
        $this->comentario = $comentario;
    }

    public function via($notifiable)
    {
        return ['database']; // 👈 IMPORTANTE
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => '💬 Nuevo comentario en tu post: ' . substr($this->comentario->contenido, 0, 50),
            'comentario_id' => $this->comentario->id,
            'post_id' => $this->comentario->post_id,
            'usuario_comentario' => $this->comentario->user->nombre,
        ];
    }
}
