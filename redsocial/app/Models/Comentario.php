<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
