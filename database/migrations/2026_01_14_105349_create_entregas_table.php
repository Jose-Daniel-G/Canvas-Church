<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->text('comentario')->nullable();
            $table->enum('estado', ['pendiente', 'calificada', 'tardia'])
                  ->default('pendiente');
            $table->string('archivo')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->boolean('entrega_tardia')->default(false);
            $table->unique(['tarea_id', 'estudiante_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
