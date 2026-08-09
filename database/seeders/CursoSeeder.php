<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------[ CURSOS ]--------------------------

        Curso::create([
            'codigo' => 'ANT-2026',
            'nombre' => 'Panorama del Antiguo Testamento',
            'horas_requeridas' => 40,
            'descripcion' => 'Estudio profundo de la historia, leyes y profetas desde el Génesis hasta Malaquías.',
            'periodo' => '2026-1',
            'estado' => true,
        ]);

        Curso::create([
            'codigo' => 'EV-2026',
            'nombre' => 'Evangelismo Personal',
            'horas_requeridas' => 20,
            'descripcion' => 'Técnicas y fundamentos bíblicos para compartir la fe de manera efectiva y práctica.',
            'periodo' => '2026-1',
            'estado' => true,
        ]);

        Curso::create([
            'codigo' => 'TEO-2026',
            'nombre' => 'Teología Sistemática I',
            'horas_requeridas' => 30,
            'descripcion' => 'Estudio de las doctrinas fundamentales: Bibliología, Teología Propia y Antropología.',
            'periodo' => '2026-1',
            'estado' => true,
        ]);
    }
}
