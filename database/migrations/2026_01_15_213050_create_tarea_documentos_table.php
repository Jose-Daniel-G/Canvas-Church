<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tarea_documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete();
            $table->string('titulo');
            $table->string('archivo'); // ruta en storage
            $table->string('tipo')->nullable(); // pdf, docx, etc

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarea_documentos');
    }
};
