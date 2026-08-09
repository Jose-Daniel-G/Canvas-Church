<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use Carbon\Carbon;

class TareaSeeder extends Seeder
{
    public function run(): void
    {
        $cursoId = 1; // Asegúrate que exista el curso Biblia / Teología

        $tareas = [

            [
                'curso_id' => $cursoId,
                'tipo' => 'tarea',
                'fecha_apertura' => Carbon::now(),
                'titulo_tarea' => 'Lectura y análisis del Génesis',
                'descripcion_tarea' => 'Leer los capítulos 1 al 3 del libro de Génesis y realizar un análisis reflexivo.',
                'requisitos' => 'Biblia (cualquier versión) y cuaderno de notas.',
                'criterios_evaluacion' => 'Comprensión del texto, análisis personal y coherencia.',
                'fecha_entrega' => Carbon::now()->addDays(7),
                'permite_entregas_tardias' => true,
                'penalizacion_tardia' => 5,
                'visible' => true,
                'intentos_permitidos' => 1,
                'formato_entrega' => 'texto',
                'puntaje' => 100,
            ],

            [
                'curso_id' => $cursoId,
                'tipo' => 'quiz',
                'fecha_apertura' => Carbon::now()->addDays(2),
                'titulo_tarea' => 'Quiz: Los Patriarcas',
                'descripcion_tarea' => 'Evaluación corta sobre Abraham, Isaac y Jacob.',
                'requisitos' => 'Haber leído Génesis capítulos 12 al 36.',
                'criterios_evaluacion' => 'Respuestas correctas y tiempo de entrega.',
                'fecha_entrega' => Carbon::now()->addDays(5),
                'permite_entregas_tardias' => false,
                'visible' => true,
                'intentos_permitidos' => 1,
                'formato_entrega' => 'texto',
                'puntaje' => 20,
            ],

            [
                'curso_id' => $cursoId,
                'tipo' => 'foro',
                'fecha_apertura' => Carbon::now()->addDays(3),
                'titulo_tarea' => 'Foro: Los Diez Mandamientos',
                'descripcion_tarea' => 'Participa en el foro opinando sobre la vigencia de los Diez Mandamientos hoy.',
                'requisitos' => 'Lectura previa de Éxodo 20.',
                'criterios_evaluacion' => 'Participación, respeto y argumentación.',
                'fecha_entrega' => Carbon::now()->addDays(10),
                'permite_entregas_tardias' => false,
                'visible' => true,
                'intentos_permitidos' => 3,
                'formato_entrega' => 'texto',
                'puntaje' => 30,
            ],

            [
                'curso_id' => $cursoId,
                'tipo' => 'proyecto',
                'fecha_apertura' => Carbon::now(),
                'titulo_tarea' => 'Proyecto: Línea de tiempo bíblica',
                'descripcion_tarea' => 'Crear una línea de tiempo desde la creación hasta el ministerio de Jesús.',
                'requisitos' => 'Investigación bíblica y referencias históricas.',
                'criterios_evaluacion' => 'Contenido, creatividad y exactitud histórica.',
                'fecha_entrega' => Carbon::now()->addDays(20),
                'permite_entregas_tardias' => true,
                'penalizacion_tardia' => 10,
                'visible' => true,
                'intentos_permitidos' => 1,
                'formato_entrega' => 'archivo',
                'formatos_aceptados' => '.pdf,.pptx',
                'tamanio_maximo' => 20,
                'puntaje' => 150,
            ],

            [
                'curso_id' => $cursoId,
                'tipo' => 'examen',
                'fecha_apertura' => Carbon::now()->addDays(15),
                'titulo_tarea' => 'Examen: Vida y enseñanzas de Jesús',
                'descripcion_tarea' => 'Examen final sobre los Evangelios.',
                'requisitos' => 'Lectura completa de los cuatro evangelios.',
                'criterios_evaluacion' => 'Exactitud doctrinal y comprensión del mensaje.',
                'fecha_entrega' => Carbon::now()->addDays(16),
                'permite_entregas_tardias' => false,
                'visible' => true,
                'intentos_permitidos' => 1,
                'formato_entrega' => 'texto',
                'puntaje' => 200,
            ],

        ];

        foreach ($tareas as $tarea) {
            Tarea::create($tarea);
        }
    }
}
