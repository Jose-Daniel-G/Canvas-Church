<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            // Información básica
            $table->string('codigo')->unique(); // ej: MAT-101
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Configuración académica
            $table->string('periodo'); // ej: 2026-1
            
            // Estado del curso JD
            $table->boolean('estado')->default(true); // activo / inactivo 
            $table->integer('horas_requeridas')->default(0); 
            
             
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
