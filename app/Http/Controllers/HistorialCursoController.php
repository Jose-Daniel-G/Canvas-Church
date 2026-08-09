<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\HistorialCurso;
use App\Models\Curso;

class HistorialCursoController extends Controller
{
    public function index($estudianteId)
    {
        $historial = HistorialCurso::with('curso')
            ->where('estudiante_id', $estudianteId)
            ->orderBy('fecha_completado', 'desc')
            ->get();

        return response()->json($historial);
    }

    public function completarCurso($estudianteId, $cursoId)
    {
        $curso = Curso::findOrFail($cursoId);

        $registro = DB::table('estudiante_curso')
            ->where('estudiante_id', $estudianteId)
            ->where('curso_id', $cursoId)
            ->first();

        if (!$registro) {
            return response()->json(['message' => 'Curso no inscrito'], 404);
        }

        if ($registro->horas_realizadas < $curso->horas_requeridas) {
            return response()->json(['message' => 'Curso aún no completado'], 400);
        }

        HistorialCurso::firstOrCreate([
            'estudiante_id' => $estudianteId,
            'curso_id' => $cursoId,
        ], [
            'fecha_completado' => now(),
        ]);

        return response()->json(['message' => 'Curso registrado en historial'], 200);
    }
}
