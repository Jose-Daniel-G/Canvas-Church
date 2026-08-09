<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Crear CLASES primero
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->string('color');
            $table->enum('estado', ['programada', 'dictada', 'cancelada'])
                  ->default('programada');

            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profesor_id')->constrained('profesors')->cascadeOnDelete();

            $table->timestamps();
        });

        // 2. Crear pivot CLASE_ESTUDIANTE
        Schema::create('clase_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['clase_id', 'estudiante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clase_estudiante');
        Schema::dropIfExists('clases');
    }
};
