<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Solo renombra si la columna vieja existe y la nueva todavía no.
        // Así es seguro correrla sin importar el estado actual de la BD.
        if (Schema::hasColumn('estudiantes', 'celular') && !Schema::hasColumn('estudiantes', 'telefono')) {
            DB::statement('ALTER TABLE estudiantes CHANGE celular telefono INT NOT NULL');
        }

        if (Schema::hasColumn('secretarias', 'celular') && !Schema::hasColumn('secretarias', 'telefono')) {
            DB::statement('ALTER TABLE secretarias CHANGE celular telefono VARCHAR(100) NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('estudiantes', 'telefono') && !Schema::hasColumn('estudiantes', 'celular')) {
            DB::statement('ALTER TABLE estudiantes CHANGE telefono celular INT NOT NULL');
        }

        if (Schema::hasColumn('secretarias', 'telefono') && !Schema::hasColumn('secretarias', 'celular')) {
            DB::statement('ALTER TABLE secretarias CHANGE telefono celular VARCHAR(100) NOT NULL');
        }
    }
};
