<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudianteClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiante = Estudiante::where('user_id', 8)->first();
        $asignaciones = [
            ['curso' => 'A1', 'horas_realizadas' => 15], // terminado
            ['curso' => 'B2', 'horas_realizadas' => 20], // terminado
            ['curso' => 'C1', 'horas_realizadas' => 10], // en progreso
        ];

        foreach ($asignaciones as $asig) {
            $curso = Curso::where('nombre', $asig['curso'])->first();

            if ($curso) {
                DB::table('estudiante_curso')->updateOrInsert(
                    [
                        'estudiante_id' => $estudiante->id,
                        'curso_id' => $curso->id,
                    ],
                    [
                        'horas_realizadas' => $asig['horas_realizadas'],
                        'fecha_realizacion' => $asig['horas_realizadas'] >= $curso->horas_requeridas ? now() : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info("✅ Cursos simulados correctamente para el estudiante '{$estudiante->nombres}' (ID: {$estudiante->id})");
    }
}
