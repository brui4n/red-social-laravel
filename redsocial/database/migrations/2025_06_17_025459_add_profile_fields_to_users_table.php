<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar columnas ANTES de la migración usando DB directo
        $existingColumns = $this->getExistingColumns();
        
        Schema::table('users', function (Blueprint $table) use ($existingColumns) {
            if (!in_array('username', $existingColumns)) {
                $table->string('username')->unique()->nullable()->after('nombre');
            }
            if (!in_array('bio', $existingColumns)) {
                $table->text('bio')->nullable()->after('email');
            }
            if (!in_array('ubicacion', $existingColumns)) {
                $table->string('ubicacion')->nullable()->after('bio');
            }
            if (!in_array('sitio_web', $existingColumns)) {
                $table->string('sitio_web')->nullable()->after('ubicacion');
            }
            if (!in_array('avatar', $existingColumns)) {
                $table->string('avatar')->nullable()->after('sitio_web');
            }
        });
    }

    public function down(): void
    {
        $existingColumns = $this->getExistingColumns();
        $columnsToRemove = ['username', 'bio', 'ubicacion', 'sitio_web', 'avatar'];
        
        Schema::table('users', function (Blueprint $table) use ($existingColumns, $columnsToRemove) {
            foreach ($columnsToRemove as $column) {
                if (in_array($column, $existingColumns)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Obtener columnas existentes usando consulta directa
     */
    private function getExistingColumns(): array
    {
        $columns = DB::select("SHOW COLUMNS FROM users");
        return array_map(function($column) {
            return $column->Field;
        }, $columns);
    }
};
