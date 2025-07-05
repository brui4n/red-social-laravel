<?php

Broadcast::channel('notificaciones.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});


