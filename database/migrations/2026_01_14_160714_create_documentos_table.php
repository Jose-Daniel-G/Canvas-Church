<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            
            $table->string('titulo_documento');
            $table->string('archivo'); // ruta en storage
            $table->string('tipo_documento')->nullable(); // pdf, docx, etc
            
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
