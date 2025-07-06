<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguidores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seguidor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seguido_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Evitar que un usuario se siga a sí mismo o siga al mismo usuario dos veces
            $table->unique(['seguidor_id', 'seguido_id']);
            
            // Índices para mejorar el rendimiento
            $table->index(['seguidor_id']);
            $table->index(['seguido_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguidores');
    }
};