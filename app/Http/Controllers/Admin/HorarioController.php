<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Horario;
use App\Models\Profesor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HorarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.horarios.index')->only('index');
        $this->middleware('can:admin.horarios.create')->only('create', 'store');
        $this->middleware('can:admin.horarios.edit')->only('edit', 'update');
        $this->middleware('can:admin.horarios.destroy')->only('destroy');
    }

    public function index()
    {
        $cursos = Curso::all();
        $horarios = Horario::with('profesores', 'cursos')->get(); // viene con la relacion del horario

        return view('admin.horarios.index', compact('horarios', 'cursos'));
    }

    public function create()
    {
        $profesores = Profesor::all();
        $cursos = Curso::all();
        $horarios = Horario::with('profesores', 'cursos')->get();

        // Inicializar como colección vacía por defecto
        $horariosExistentes = collect();

        // Solo cargar si el usuario NO tiene permiso
        if (!auth()->user()->can('admin.acciones.seleccionCursos')) {
            $horariosExistentes = Horario::with('cursos')
                ->select('id', 'dia', 'hora_inicio', 'hora_fin', 'profesor_id')
                ->get()
                ->groupBy('profesor_id');
        }

        return view('admin.horarios.create', compact('profesores', 'cursos', 'horarios', 'horariosExistentes'));
    }

    public function show_datos_por_curso($cursoId)
    {
        try {
            // Obtener horarios del curso seleccionado
            $horarios = Horario::whereHas('cursos', function ($query) use ($cursoId) {
                $query->where('curso_id', $cursoId);
            })->with(['cursos', 'profesores'])->get();

            // Obtener clases programadas para este curso
            $horarios_asignados = DB::table('clases')
                ->select([
                    'clases.id AS clase_id',
                    'clases.profesor_id',
                    'clases.curso_id',
                    'clases.fecha_hora_inicio AS hora_inicio',
                    'clases.fecha_hora_fin AS hora_fin',
                    DB::raw('DAYNAME(clases.fecha_hora_inicio) AS dia'),
                    'users.id AS user_id',
                    'users.name AS user_nombre',
                    'cursos.nombre AS curso_nombre',
                ])
                ->join('cursos', 'clases.curso_id', '=', 'cursos.id')
                ->join('clase_estudiante', 'clases.id', '=', 'clase_estudiante.clase_id')
                ->join('estudiantes', 'clase_estudiante.estudiante_id', '=', 'estudiantes.id')
                ->join('users', 'estudiantes.user_id', '=', 'users.id')
                ->where('clases.curso_id', $cursoId)
                ->get();

            // Traducir días al español
            $horarios_asignados = $horarios_asignados->map(function ($horario) {
                $horario->dia = DateHelper::traducirDia($horario->dia);

                return $horario;
            });

            return view('admin.horarios.show_datos_cursos', compact('horarios', 'horarios_asignados'));
        } catch (\Exception $exception) {
            return response()->json(['mensaje' => 'Error', 'detalle' => $exception->getMessage()]);
        }
    }

public function show_datos_cursos($id)
{
    try {
        $profesor = Profesor::findOrFail($id);

        // 1. LÓGICA DE CURSOS
        // Buscamos si ya tiene un curso asignado en la tabla pivote
        $cursoAsignado = DB::table('horario_profesor_curso')
            ->join('cursos', 'horario_profesor_curso.curso_id', '=', 'cursos.id')
            ->where('horario_profesor_curso.profesor_id', $id)
            ->select('cursos.id', 'cursos.nombre')
            ->first();

        $tieneCurso = !is_null($cursoAsignado);

        // Si tiene curso, enviamos la lista de disponibles vacía. 
        // Si no tiene, enviamos todos los cursos activos.
        $cursosDisponibles = $tieneCurso 
            ? [] 
            : Curso::where('estado', 1)->get(['id', 'nombre']);

        // 2. LÓGICA DE TABLA DE HORARIOS (HTML)
        $horarios = Horario::where('profesor_id', $id)->with('cursos')->get();

        $horarios_asignados = DB::table('clases')
            ->select([
                'clases.id AS clase_id',
                'clases.fecha_hora_inicio AS hora_inicio',
                'clases.fecha_hora_fin AS hora_fin',
                DB::raw('DAYNAME(clases.fecha_hora_inicio) AS dia'),
                'users.name AS user_nombre',
                'cursos.nombre AS curso_nombre',
            ])
            ->join('cursos', 'clases.curso_id', '=', 'cursos.id')
            ->join('clase_estudiante', 'clases.id', '=', 'clase_estudiante.clase_id')
            ->join('estudiantes', 'clase_estudiante.estudiante_id', '=', 'estudiantes.id')
            ->join('users', 'estudiantes.user_id', '=', 'users.id')
            ->where('clases.profesor_id', $id)
            ->get()
            ->map(function ($h) {
                $h->dia = \App\Helpers\DateHelper::traducirDia($h->dia);
                return $h;
            });

        $tablaHtml = view('admin.horarios.show_datos_cursos', compact('horarios', 'horarios_asignados'))->render();

        return response()->json([
            'tiene_curso'    => $tieneCurso,
            'curso_asignado' => $cursoAsignado, // Contiene id y nombre
            'cursos'         => $cursosDisponibles,
            'html_tabla'     => $tablaHtml,
            'mensaje'        => $tieneCurso ? 'Este profesor ya tiene el curso: ' . $cursoAsignado->nombre : null
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al procesar: ' . $e->getMessage()], 500);
    }
}

        public function store(Request $request)
        {
            Log::info('=== INICIO DEL PROCESO ===');
            
            try {
                $validatedData = $request->validate([
                    'dia' => 'required',
                    'hora_inicio' => 'required|date_format:H:i',
                    'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                    'profesor_id' => 'required|exists:profesors,id',
                    'cursos' => 'required|array|min:1',
                    'cursos.*' => 'exists:cursos,id',
                ]);

                $horaInicio = Carbon::parse($validatedData['hora_inicio'])->format('H:i:s');
                $horaFin    = Carbon::parse($validatedData['hora_fin'])->format('H:i:s');
                $user       = auth()->user();

                // Permisos
                $puedeCrearNuevos     = $user->can('admin.horarios.crear_nuevos');
                $puedeMultiplesCursos = $user->can('admin.acciones.seleccionCursos');

                // 1. BUSCAR HORARIO EXACTO (Para evitar duplicados idénticos)
                $horarioExacto = Horario::where('dia', $validatedData['dia'])
                    ->where('profesor_id', $validatedData['profesor_id'])
                    ->where('hora_inicio', $horaInicio)
                    ->where('hora_fin', $horaFin)
                    ->first();

                if ($horarioExacto) {
                    // Lógica de asociación de cursos (Tu Caso 2)
                    return $this->asociarCursosAHorario($horarioExacto, $validatedData);
                }

                // 2. VERIFICAR CONFLICTOS (Traslapes)
                // Buscamos si hay algún horario que choque con este rango
                $conflicto = Horario::where('dia', $validatedData['dia'])
                    ->where('profesor_id', $validatedData['profesor_id'])
                    ->where(function ($query) use ($horaInicio, $horaFin) {
                        $query->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                            ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                            ->orWhere(function ($q) use ($horaInicio, $horaFin) {
                                $q->where('hora_inicio', '<=', $horaInicio)
                                    ->where('hora_fin', '>=', $horaFin);
                            });
                    })->first();

                if ($conflicto) {
                    return back()->withInput()->with([
                        'swal' => '1',
                        'info' => 'El profesor ya tiene un compromiso en este rango de horas.',
                        'icon' => 'error',
                    ]);
                }

                // 3. SI NO HAY CONFLICTO, CREAR NUEVO (Permite múltiples horarios al día)
                if ($puedeCrearNuevos) {
                    return $this->crearNuevoHorario($validatedData, $horaInicio, $horaFin);
                }

                return back()->withInput()->with([
                    'swal' => '1',
                    'info' => 'No tiene permisos suficientes para crear este horario.',
                    'icon' => 'error',
                ]);

            } catch (\Exception $e) {
                Log::error('ERROR STORE HORARIO', [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);

                return back()->withInput()->with([
                    'swal' => '1',
                    'info' => 'Error inesperado: ' . $e->getMessage(),
                    'icon' => 'error',
                ]);
            }
        }


    // ================================
    // MÉTODOS AUXILIARES
    // ================================

    private function crearNuevoHorario($validatedData, $horaInicio, $horaFin)
    {
        DB::beginTransaction();

        try {
            $horario = Horario::create([
                'dia' => $validatedData['dia'],
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
                'profesor_id' => $validatedData['profesor_id'],
            ]);

            Log::info('Nuevo horario creado', ['horario_id' => $horario->id]);

            foreach ($validatedData['cursos'] as $cursoId) {
                DB::table('horario_profesor_curso')->insert([
                    'horario_id' => $horario->id,
                    'curso_id' => $cursoId,
                    'profesor_id' => $validatedData['profesor_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.horarios.index')
                ->with([
                    'swal' => '1',
                    'info' => 'Horario registrado correctamente.',
                    'icon' => 'success',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function asociarCursosAHorario($horario, $validatedData)
    {
        DB::beginTransaction();

        try {
            foreach ($validatedData['cursos'] as $cursoId) {
                DB::table('horario_profesor_curso')->updateOrInsert(
                    [
                        'horario_id' => $horario->id,
                        'curso_id' => $cursoId,
                        'profesor_id' => $validatedData['profesor_id'],
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.horarios.index')
                ->with([
                    'swal' => '1',
                    'info' => 'Cursos asociados correctamente.',
                    'icon' => 'success',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function verificarConflicto($validatedData, $horaInicio, $horaFin)
    {
        return Horario::where('dia', $validatedData['dia'])
            ->where('profesor_id', $validatedData['profesor_id'])
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where(function ($q) use ($horaInicio) {
                    $q->where('hora_inicio', '<=', $horaInicio)
                        ->where('hora_fin', '>', $horaInicio);
                })
                    ->orWhere(function ($q) use ($horaFin) {
                        $q->where('hora_inicio', '<', $horaFin)
                            ->where('hora_fin', '>=', $horaFin);
                    })
                    ->orWhere(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '>=', $horaInicio)
                            ->where('hora_fin', '<=', $horaFin);
                    });
            })
            ->first();
    }

    public function show(Horario $horario)
    {
        $horario->load('profesores', 'cursos');

        return view('admin.horarios.show', compact('horario'));
    }

    public function edit(Horario $horario)
    {
        $horario->load(['profesores', 'cursos']); // Cargar relaciones
        $profesores = Profesor::all();
        $cursos = Curso::all();

        return response()->json(['horario' => $horario->toArray(),  'profesores' => $profesores, 'cursos' => $cursos]);
    }

    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'dia' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'curso_id' => 'required',
        ]);
        // Actualizar datos propios del horario
        $horario->update([
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        $horario->profesores()->syncWithPivotValues(
            [$request->profesor_id],
            ['curso_id' => $request->curso_id]
        );

        return redirect()->route('admin.horarios.index')
            ->with(['info' => 'Horario actualizado correctamente.', 'icon', 'success']);
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('admin.horarios.index')->with(['title' => 'Exito', 'info' => 'El horario se eliminó con éxito', 'icon', 'success']);
    }
}
