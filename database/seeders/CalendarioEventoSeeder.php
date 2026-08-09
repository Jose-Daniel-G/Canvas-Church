<?php

namespace Database\Seeders;

use App\Models\CalendarioEvento;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class CalendarioEventoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener cursos
        $cursoANT = Curso::where('codigo', 'ANT-2026')->first();
        $cursoEV  = Curso::where('codigo', 'EV-2026')->first();
        $cursoTEO = Curso::where('codigo', 'TEO-2026')->first();

        // ========================================================================
        // CURSO: Panorama del Antiguo Testamento (ANT-2026)
        // ========================================================================
        if ($cursoANT) {
            $eventosANT = [
                // Enero 2026
                ['fecha' => '2026-01-27', 'titulo' => 'Inicio de clases', 'tipo' => 'otro'],

                // Febrero 2026
                ['fecha' => '2026-02-10', 'titulo' => 'Examen: Pentateuco (Génesis-Deuteronomio)', 'tipo' => 'examen'],
                ['fecha' => '2026-02-20', 'titulo' => 'Entrega: Trabajo sobre Ley Mosaica', 'tipo' => 'entrega'],

                // // Marzo 2026
                // ['fecha' => '2026-03-05', 'titulo' => 'Parcial I: Libros Históricos', 'tipo' => 'parcial'],
                // ['fecha' => '2026-03-19', 'titulo' => 'Entrega: Análisis de Jueces y Reyes', 'tipo' => 'entrega'],
                // ['fecha' => '2026-03-24', 'titulo' => 'Semana Santa - No hay clases', 'tipo' => 'festivo'],

                // // Abril 2026
                // ['fecha' => '2026-04-09', 'titulo' => 'Examen: Libros Poéticos (Job, Salmos, Proverbios)', 'tipo' => 'examen'],
                // ['fecha' => '2026-04-23', 'titulo' => 'Entrega: Ensayo sobre Sabiduría Bíblica', 'tipo' => 'entrega'],

                // // Mayo 2026
                // ['fecha' => '2026-05-01', 'titulo' => 'Día del Trabajo - No hay clases', 'tipo' => 'festivo'],
                // ['fecha' => '2026-05-14', 'titulo' => 'Parcial II: Profetas Mayores', 'tipo' => 'parcial'],
                // ['fecha' => '2026-05-28', 'titulo' => 'Entrega: Estudio de Isaías', 'tipo' => 'entrega'],

                // // Junio 2026
                // ['fecha' => '2026-06-11', 'titulo' => 'Examen Final: Profetas Menores', 'tipo' => 'examen'],
                // ['fecha' => '2026-06-18', 'titulo' => 'Entrega: Proyecto final del curso', 'tipo' => 'entrega'],
            ];

            foreach ($eventosANT as $evento) {
                CalendarioEvento::create([
                    'curso_id' => $cursoANT->id,
                    'fecha' => $evento['fecha'],
                    'titulo' => $evento['titulo'],
                    'tipo' => $evento['tipo'],
                ]);
            }
        }

        // ========================================================================
        // CURSO: Evangelismo Personal (EV-2026)
        // ========================================================================
        if ($cursoEV) {
            $eventosEV = [
                // Enero 2026
                ['fecha' => '2026-01-28', 'titulo' => 'Inicio de clases', 'tipo' => 'otro'],

                // Febrero 2026
                ['fecha' => '2026-02-12', 'titulo' => 'Entrega: Plan personal de evangelismo', 'tipo' => 'entrega'],
                ['fecha' => '2026-02-25', 'titulo' => 'Práctica: Salida evangelística grupal', 'tipo' => 'otro'],

                // // Marzo 2026
                // ['fecha' => '2026-03-10', 'titulo' => 'Parcial I: Fundamentos bíblicos del evangelismo', 'tipo' => 'parcial'],
                // ['fecha' => '2026-03-20', 'titulo' => 'Entrega: Testimonio personal escrito', 'tipo' => 'entrega'],
                // ['fecha' => '2026-03-24', 'titulo' => 'Semana Santa - No hay clases', 'tipo' => 'festivo'],

                // // Abril 2026
                // ['fecha' => '2026-04-08', 'titulo' => 'Taller práctico: Cómo compartir el evangelio', 'tipo' => 'otro'],
                // ['fecha' => '2026-04-22', 'titulo' => 'Entrega: Reporte de actividades evangelísticas', 'tipo' => 'entrega'],

                // // Mayo 2026
                // ['fecha' => '2026-05-01', 'titulo' => 'Día del Trabajo - No hay clases', 'tipo' => 'festivo'],
                // ['fecha' => '2026-05-15', 'titulo' => 'Examen práctico: Presentación del evangelio', 'tipo' => 'examen'],
                // ['fecha' => '2026-05-29', 'titulo' => 'Proyecto final: Campaña evangelística', 'tipo' => 'entrega'],
            ];

            foreach ($eventosEV as $evento) {
                CalendarioEvento::create([
                    'curso_id' => $cursoEV->id,
                    'fecha' => $evento['fecha'],
                    'titulo' => $evento['titulo'],
                    'tipo' => $evento['tipo'],
                ]);
            }
        }

        // ========================================================================
        // CURSO: Teología Sistemática I (TEO-2026)
        // ========================================================================
        if ($cursoTEO) {
            $eventosTEO = [
                // Enero 2026
                ['fecha' => '2026-01-29', 'titulo' => 'Inicio de clases', 'tipo' => 'otro'],

                // Febrero 2026
                ['fecha' => '2026-02-13', 'titulo' => 'Examen: Bibliología (Doctrina de las Escrituras)', 'tipo' => 'examen'],
                ['fecha' => '2026-02-26', 'titulo' => 'Entrega: Ensayo sobre Inspiración Bíblica', 'tipo' => 'entrega'],

                // // Marzo 2026
                // ['fecha' => '2026-03-12', 'titulo' => 'Parcial I: Teología Propia (Doctrina de Dios)', 'tipo' => 'parcial'],
                // ['fecha' => '2026-03-21', 'titulo' => 'Entrega: Atributos de Dios - Estudio comparativo', 'tipo' => 'entrega'],
                // ['fecha' => '2026-03-24', 'titulo' => 'Semana Santa - No hay clases', 'tipo' => 'festivo'],

                // // Abril 2026
                // ['fecha' => '2026-04-10', 'titulo' => 'Examen: Trinidad y naturaleza de Dios', 'tipo' => 'examen'],
                // ['fecha' => '2026-04-24', 'titulo' => 'Entrega: Trabajo sobre la Trinidad', 'tipo' => 'entrega'],

                // // Mayo 2026
                // ['fecha' => '2026-05-01', 'titulo' => 'Día del Trabajo - No hay clases', 'tipo' => 'festivo'],
                // ['fecha' => '2026-05-08', 'titulo' => 'Parcial II: Antropología (Doctrina del Hombre)', 'tipo' => 'parcial'],
                // ['fecha' => '2026-05-22', 'titulo' => 'Entrega: Creación, Caída y Redención del hombre', 'tipo' => 'entrega'],

                // // Junio 2026
                // ['fecha' => '2026-06-05', 'titulo' => 'Examen Final Integrador', 'tipo' => 'examen'],
                // ['fecha' => '2026-06-12', 'titulo' => 'Entrega: Tesina de Teología Sistemática', 'tipo' => 'entrega'],
                // ['fecha' => '2026-06-19', 'titulo' => 'Exposiciones finales', 'tipo' => 'otro'],
            ];

            foreach ($eventosTEO as $evento) {
                CalendarioEvento::create([
                    'curso_id' => $cursoTEO->id,
                    'fecha' => $evento['fecha'],
                    'titulo' => $evento['titulo'],
                    'tipo' => $evento['tipo'],
                ]);
            }
        }

        $this->command->info('✅ Eventos de calendario creados exitosamente para todos los cursos.');
    }
}
