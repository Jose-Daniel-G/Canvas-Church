<?php

namespace App\Http\Controllers\Academico\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Tarea;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $profesor = Auth::user()->profesor;
        $cursos = $profesor->cursos;
        $cursoSeleccionado = null;
        $estudiantes = [];
        $tareasDelCurso = [];

        if ($request->filled('curso_id')) {
            $cursoSeleccionado = Curso::find($request->curso_id);

            $tareasDelCurso = Tarea::where('curso_id', $request->curso_id)
                ->orderBy('fecha_entrega', 'asc')
                ->get();

            $estudiantes = $cursoSeleccionado->estudiantes()
                ->with(['user', 'calificaciones' => function ($q) use ($request) {
                    $q->where('curso_id', $request->curso_id);
                }, 'entregas']) // <-- IMPORTANTE: Cargamos las entregas aquí
                ->get();
        }

        return view('profesor.calificaciones.index', compact('cursos', 'estudiantes', 'cursoSeleccionado', 'tareasDelCurso'));
    }

    /**
     * Store: Califica la tarea enviada.
     * Ya conocemos el tipo (tarea), nota máxima y concepto desde el modelo Tarea.
     */
    public function store(Request $request)
    {
        $request->validate([
            'entrega_id' => 'required|exists:entregas,id',
            'nota' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string'
        ]);

        $entrega = Entrega::with('tarea')->findOrFail($request->entrega_id);
        $tarea = $entrega->tarea;

        // Validar contra el puntaje configurado en la tarea
        if ($request->nota > $tarea->puntaje) {
            return back()->withErrors(['nota' => "La nota máxima permitida es {$tarea->puntaje}"]);
        }

        try {
            Calificacion::updateOrCreate(
                ['entrega_id' => $entrega->id],
                [
                    'estudiante_id'    => $entrega->estudiante_id,
                    'curso_id'         => $tarea->curso_id,
                    'profesor_id'      => Auth::user()->profesor->id,
                    'concepto'         => $tarea->titulo_tarea,
                    'nota'             => $request->nota,
                    'nota_maxima'      => $tarea->puntaje,
                    'porcentaje'       => $tarea->porcentaje ?? 100,
                    'tipo_evaluacion'  => 'tarea',
                    'fecha_calificacion' => now(),
                    'observaciones'    => $request->observaciones,
                    'publicada'        => true
                ]
            );
            return  back()->with([ 'swal'=> 2,'title' => 'Éxito', 'info' => 'Calificación guardada correctamente.', 'icon' => 'success']); 
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }
    public function revision($id)
    {
        $entrega = Entrega::with(['estudiante.user', 'tarea', 'calificacion'])->findOrFail($id);
        // Debug opcional: Si esto lanza null, el problema es el dato en la DB
        if (!$entrega->estudiante) {  return back()->with('error', 'Esta entrega no tiene un estudiante válido asociado.');}

        return view('profesor.calificaciones.revision', compact('entrega'));
    }
    /**
     * Muestra una calificación específica (opcional).
     */
    public function show(string $id)
    {
        $calificacion = Calificacion::with(['estudiante.user', 'entrega.tarea'])->findOrFail($id);
        return view('profesor.calificaciones.show', compact('calificacion'));
    }

    /**
     * Edición de una calificación manual desde el libro.
     */
    public function edit(string $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        return view('profesor.calificaciones.edit', compact('calificacion'));
    }

    /**
     * Actualiza la calificación en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['nota' => 'required|numeric|min:0']);

        $calificacion = Calificacion::findOrFail($id);
        $calificacion->update([
            'nota' => $request->nota,
            'observaciones' => $request->observaciones,
            'fecha_calificacion' => now()
        ]);

        return redirect()->route('profesor.calificaciones.index')->with('success', 'Nota actualizada.');
    }

    /**
     * Elimina una calificación.
     */
    public function destroy(string $id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();

        return redirect()->route('profesor.calificaciones.index')->with('success', 'Calificación eliminada.');
    }

    /**
     * Método adicional para Guardado Masivo desde la tabla principal (Libro de Notas).
     */
    public function storeMasiva(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'calificaciones' => 'required|array'
        ]);

        try {
            DB::beginTransaction();
            foreach ($request->calificaciones as $estudianteId => $notas) {
                foreach ($notas as $concepto => $valor) {
                    if ($valor !== null) {
                        Calificacion::updateOrCreate(
                            [
                                'estudiante_id' => $estudianteId,
                                'curso_id' => $request->curso_id,
                                'concepto' => $concepto,
                                'periodo' => '2026-1'
                            ],
                            [
                                'profesor_id' => Auth::user()->profesor->id,
                                'nota' => $valor,
                                'nota_maxima' => 5.0,
                                'tipo_evaluacion' => $this->detectarTipo($concepto),
                                'fecha_calificacion' => now(),
                                'publicada' => true
                            ]
                        );
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Libro de calificaciones sincronizado.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function detectarTipo($concepto)
    {
        if (str_starts_with($concepto, 'T')) return 'tarea';
        if (str_starts_with($concepto, 'Q')) return 'quiz';
        if (str_starts_with($concepto, 'P')) return 'parcial';
        return 'otro';
    }
}
