<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InscripcionController extends Controller
{
    /**
     * Mostrar todas las inscripciones.
     */
    public function index()
    {
        $inscripciones = DB::table('estudiante_curso')
            ->join('estudiantes', 'estudiante_curso.estudiante_id', '=', 'estudiantes.id')
            ->join('cursos', 'estudiante_curso.curso_id', '=', 'cursos.id')
            ->select(
                'estudiante_curso.id',
                'estudiantes.id as estudiante_id',
                'estudiantes.nombres',
                'estudiantes.apellidos',
                'estudiantes.cc',
                'cursos.id as curso_id',
                'cursos.nombre as curso_nombre',
                'cursos.codigo',
                'cursos.periodo',
                'estudiante_curso.estado',
                'estudiante_curso.fecha_inscripcion',
                'estudiante_curso.horas_realizadas'
            )
            ->orderBy('estudiante_curso.created_at', 'desc')
            ->paginate(15);

        return view('admin.inscripciones.index', compact('inscripciones'));
    }

    /**
     * Mostrar formulario de inscripción.
     */
    public function create()
    {
        // Estudiantes que NO estén inscritos en ningún curso
        $estudiantes = Estudiante::whereDoesntHave('cursos')
            ->orderBy('nombres')
            ->get();

        // Cursos activos
        $cursos = Curso::where('estado', true)
            ->orderBy('nombre')
            ->get();
        // Profesores iniciales (opcional, se cargarán vía AJAX por curso)
        $profesores = Profesor::orderBy('nombres')->get();
        return view('admin.inscripciones.create', compact('estudiantes', 'cursos', 'profesores'));
    }
    // Método para obtener profesores por curso vía AJAX
    public function getProfesoresPorCurso($cursoId)
    {
        $profesores = Profesor::whereHas('horarios.cursos', function ($q) use ($cursoId) {
            $q->where('curso_id', $cursoId);
        })->get(['profesors.id', 'nombres', 'apellidos']); // Ajusta nombres de campos si es necesario
        Log::info("Profesores para el curso ID $cursoId: " . $profesores->toJson());
        return response()->json($profesores);
    }
    /**
     * Guardar inscripción.
     */
public function store(Request $request)
{
    $request->validate([
        'estudiante_id' => 'required|exists:estudiantes,id',
        'curso_id'      => 'required|exists:cursos,id',
        'profesor_id'   => 'required|exists:profesors,id', // Se usa para filtrar clases
    ]);

    try {
        DB::beginTransaction();

        // 1. Registro en la tabla de progreso académico (Sin profesor_id)
        DB::table('estudiante_curso')->updateOrInsert(
            ['estudiante_id' => $request->estudiante_id, 'curso_id' => $request->curso_id],
            [
                'fecha_inscripcion' => now(),
                'horas_realizadas'  => 0,
                'estado'            => 'activo',
                'updated_at'        => now(),
            ]
        );

        // 2. Obtener las clases específicas de ese profesor para ese curso
        // Según tu migración, aquí sí es obligatorio el profesor_id
        $clasesIds = DB::table('clases')
            ->where('curso_id', 1)
            ->where('profesor_id', $request->profesor_id)
            ->pluck('id');

        // 3. Vincular al estudiante con cada sesión/clase para la asistencia
        if ($clasesIds->isNotEmpty()) {
            foreach ($clasesIds as $claseId) {
                DB::table('clase_estudiante')->updateOrInsert(
                    ['clase_id' => $claseId, 'estudiante_id' => $request->estudiante_id],
                    ['updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        DB::commit();
        return redirect()->route('admin.inscripciones.index')
            ->with('success', 'Inscripción y asignación de clases completada.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Error en inscripción: " . $e->getMessage());
        return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * Inscripción masiva.
     */
    public function storeMultiple(Request $request)
    {
        // 1. Validación de los datos recibidos
        $request->validate([
            'curso_id'     => 'required|exists:cursos,id',
            'profesor_id'  => 'required|exists:profesors,id',
            'estudiantes'  => 'required|array|min:1',
            'estudiantes.*' => 'exists:estudiantes,id',
        ]);

        try {
            DB::beginTransaction();

            $cursoId = $request->curso_id;
            $profesorId = $request->profesor_id;
            $estudiantesIds = $request->estudiantes;

            // Buscamos las clases/horarios programados para este curso y profesor
            $clasesIds = DB::table('clases')
                ->where('curso_id', $cursoId)
                ->where('profesor_id', $profesorId)
                ->pluck('id');

            foreach ($estudiantesIds as $estudianteId) {

                // A. Evitar duplicados para cada estudiante
                $existe = DB::table('estudiante_curso')
                    ->where('estudiante_id', $estudianteId)
                    ->where('curso_id', $cursoId)
                    ->exists();

                if (!$existe) {
                    // B. Insertar en tabla de progreso (estudiante_curso)
                    DB::table('estudiante_curso')->insert([
                        'estudiante_id'     => $estudianteId,
                        'curso_id'          => $cursoId,
                        'profesor_id'       => $profesorId,
                        'fecha_inscripcion' => now(),
                        'horas_realizadas'  => 0,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    // C. Vincular masivamente a las clases para la lista de asistencia
                    if ($clasesIds->isNotEmpty()) {
                        $pivotClases = [];
                        foreach ($clasesIds as $claseId) {
                            $pivotClases[] = [
                                'clase_id'      => $claseId,
                                'estudiante_id' => $estudianteId,
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ];
                        }
                        DB::table('clase_estudiante')->insert($pivotClases);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.inscripciones.index')
                ->with('success', count($estudiantesIds) . ' estudiantes inscritos masivamente con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error en la inscripción masiva: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar inscripción.
     */
    public function destroy($id)
    {
        $inscripcion = DB::table('estudiante_curso')->where('id', $id)->first();

        if (!$inscripcion) {
            return back()->with('error', 'Inscripción no encontrada.');
        }

        // Verificar asistencias
        $tieneAsistencias = DB::table('asistencias')
            ->join('clases', 'asistencias.clase_id', '=', 'clases.id')
            ->where('clases.curso_id', $inscripcion->curso_id)
            ->where('asistencias.estudiante_id', $inscripcion->estudiante_id)
            ->exists();

        if ($tieneAsistencias) {
            return back()
                ->with('error', 'No se puede eliminar. El estudiante tiene asistencias registradas.');
        }

        DB::table('estudiante_curso')->where('id', $id)->delete();

        return back()->with('success', 'Inscripción eliminada correctamente.');
    }

    /**
     * Ver estudiantes de un curso.
     */
    public function estudiantesPorCurso($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);

        $estudiantes = Estudiante::join('estudiante_curso', 'estudiantes.id', '=', 'estudiante_curso.estudiante_id')
            ->where('estudiante_curso.curso_id', $cursoId)
            ->select(
                'estudiantes.*',
                'estudiante_curso.fecha_inscripcion',
                'estudiante_curso.horas_realizadas',
                'estudiante_curso.id as inscripcion_id'
            )
            ->orderBy('estudiantes.nombres')
            ->get();

        return view('admin.inscripciones.estudiantes', compact('curso', 'estudiantes'));
    }

    /**
     * Ver cursos de un estudiante.
     */
    public function cursosPorEstudiante($estudianteId)
    {
        $estudiante = Estudiante::with('cursos')->findOrFail($estudianteId);

        $cursos = $estudiante->cursos()
            ->orderByPivot('fecha_inscripcion', 'desc')
            ->get();

        return view('admin.inscripciones.cursos', compact('estudiante', 'cursos'));
    }
}
