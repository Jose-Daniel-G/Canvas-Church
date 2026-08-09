<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 
    public function up(): void
    {
        // Para eventos académicos (exámenes, entregas, festivos)
        Schema::create('calendario_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['examen', 'entrega', 'parcial', 'festivo', 'otro'])->default('otro');
            $table->string('color', 7)->default('#3490dc');

            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('calendario_eventos');
    }
};
