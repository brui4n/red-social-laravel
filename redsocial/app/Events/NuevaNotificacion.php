<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NuevaNotificacion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notificacion;
    public $userId;

    public function __construct($notificacion, $userId)
    {
        $this->notificacion = $notificacion;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notificaciones.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'nueva-notificacion';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->notificacion->id,
            'mensaje' => $this->notificacion->data['mensaje'] ?? 'Tienes una nueva notificación',
            'usuario' => $this->notificacion->data['usuario_comentario'] ?? $this->notificacion->data['usuario_like'] ?? 'Alguien',
            'post_id' => $this->notificacion->data['post_id'],
        ];
    }
}
