<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'ubicacion',    
        'sitio_web',    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function liked_posts()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }
    
    /**
     * Usuarios que este usuario sigue
     */
    public function siguiendo()
    {
        return $this->belongsToMany(
            User::class, 
            'seguidores',           // nombre de la tabla pivot
            'seguidor_id',          // clave foránea del usuario que sigue
            'seguido_id'            // clave foránea del usuario seguido
        )->withTimestamps();
    }

    /**
     * Usuarios que siguen a este usuario
     */
    public function seguidores()
    {
        return $this->belongsToMany(
            User::class, 
            'seguidores',           // nombre de la tabla pivot
            'seguido_id',           // clave foránea del usuario seguido
            'seguidor_id'           // clave foránea del usuario que sigue
        )->withTimestamps();
    }

    /**
     * Obtener las iniciales del nombre
     */
    public function initials(): string
    {
        return Str::of($this->nombre)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Verificar si este usuario sigue a otro usuario
     */
    public function estaSiguiendo(User $usuario): bool
    {
        return $this->siguiendo()->where('seguido_id', $usuario->id)->exists();
    }

    /**
     * Seguir a un usuario
     */
    public function seguir(User $usuario): void
    {
        if (!$this->estaSiguiendo($usuario) && $this->id !== $usuario->id) {
            $this->siguiendo()->attach($usuario->id);
        }
    }

    /**
     * Dejar de seguir a un usuario
     */
    public function dejarDeSeguir(User $usuario): void
    {
        $this->siguiendo()->detach($usuario->id);
    }

    /**
     * Alternar seguimiento (seguir/dejar de seguir)
     */
    public function alternarSeguimiento(User $usuario): bool
    {
        if ($this->estaSiguiendo($usuario)) {
            $this->dejarDeSeguir($usuario);
            return false; // Ya no lo sigue
        } else {
            $this->seguir($usuario);
            return true; // Ahora lo sigue
        }
    }

    /**
     * Obtener estadísticas del usuario
     */
    public function estadisticas(): array
    {
        return [
            'posts_count' => $this->posts()->count(),
            'seguidores_count' => $this->seguidores()->count(),
            'siguiendo_count' => $this->siguiendo()->count(),
            'likes_dados' => $this->liked_posts()->count(),
        ];
    }

    /**
     * Scope para buscar usuarios por nombre o username
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('username', 'like', "%{$termino}%");
    }
}