<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
        'imagen',
        'archivo',
        'codigo',
        'lenguaje',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function users_liked()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
}
