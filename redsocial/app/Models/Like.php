<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'usuario_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
