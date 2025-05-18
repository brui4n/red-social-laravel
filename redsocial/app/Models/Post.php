<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'titulo',
        'contenido',
        'imagen',
        'archivo',
        'codigo',
        'lenguaje',
    ];
    
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

}
