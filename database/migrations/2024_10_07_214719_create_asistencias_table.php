<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['presente', 'ausente', 'tardanza', 'excusado'])->default('presente');
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clase_id')->constrained()->cascadeOnDelete();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            // evita duplicados
            $table->unique(['estudiante_id', 'clase_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
