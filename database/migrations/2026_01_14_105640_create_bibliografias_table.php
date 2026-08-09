<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('bibliografias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('titulo'); 
            $table->string('autor')->nullable();
             $table->enum('tipo', ['libro', 'articulo', 'web']);
            $table->string('url')->nullable();
            $table->timestamps();
        });
    } 
    public function down(): void
    {
        Schema::dropIfExists('bibliografias');
    }
};
