<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');

            // ADICIONALES
            $table->enum('tipo', ['tarea', 'quiz', 'examen', 'proyecto', 'foro'])->default('tarea');
            $table->dateTime('fecha_apertura')->nullable();
            // -------------
            
            $table->string('titulo_tarea');
            $table->text('descripcion_tarea')->nullable();

            // ADICIONALES
            $table->text('requisitos')->nullable();
            $table->text('criterios_evaluacion')->nullable();
            // -------------
            $table->date('fecha_entrega')->nullable();
            // ADICIONALES
            $table->boolean('permite_entregas_tardias')->default(false);
            $table->decimal('penalizacion_tardia', 5, 2)->default(0);
            $table->boolean('visible')->default(true);
            $table->integer('intentos_permitidos')->default(1);
            $table->enum('formato_entrega', ['archivo', 'enlace', 'texto', 'ambos'])->default('archivo');
            $table->string('formatos_aceptados')->nullable(); // .zip,.pdf,.docx
            $table->integer('tamanio_maximo')->default(50); // MB
            // --------------
            $table->decimal('puntaje', 5, 2)->default(100);

            // Índices
            $table->index('visible');
            $table->index(['curso_id', 'fecha_entrega']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
