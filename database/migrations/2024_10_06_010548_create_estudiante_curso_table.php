<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estudiante_curso', function (Blueprint $table) {
            $table->id();  // JD
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->integer('horas_realizadas')->default(0);
            $table->timestamp('fecha_inscripcion')->nullable();
            $table->enum('estado',['activo','retirado','aprobado','reprobado'])->default('activo');
            $table->timestamps(); $table->unique(['estudiante_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiante_curso');
    }
};
