<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('profesor_id')->constrained('profesors')->onDelete('cascade');
            $table->foreignId('entrega_id')->nullable()->constrained('entregas')->onDelete('set null');
            
            $table->string('concepto', 255);
            $table->decimal('nota', 5, 2);
            $table->decimal('nota_maxima', 5, 2)->default(5.0);
            $table->integer('porcentaje')->default(100);
            
            $table->enum('tipo_evaluacion', [
                'examen',
                'parcial', 
                'quiz',
                'tarea',
                'proyecto',
                'participacion',
                'asistencia',
                'otro'
            ])->default('otro');
            
            $table->string('periodo', 50)->nullable();
            $table->date('fecha_calificacion');
            $table->text('observaciones')->nullable();
            $table->boolean('publicada')->default(false);
            
            $table->timestamps();
            
            $table->index(['estudiante_id', 'curso_id']);
            $table->index(['curso_id', 'periodo']);
            $table->index(['profesor_id', 'fecha_calificacion']);
            $table->index('tipo_evaluacion');
            $table->index('publicada');
            $table->unique(['entrega_id']);
            $table->unique(['estudiante_id', 'curso_id', 'concepto', 'periodo']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};