<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('username')->unique()->after('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio')->nullable(); // opcional
            $table->string('avatar')->nullable(); // ruta o nombre del archivo
            $table->timestamps(); // created_at y updated_at
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
