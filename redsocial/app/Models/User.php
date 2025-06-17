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
    ];

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

    public function initials(): string
    {
        return Str::of($this->nombre)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
