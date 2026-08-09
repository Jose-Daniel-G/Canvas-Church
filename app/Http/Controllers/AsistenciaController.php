<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Clase;
use App\Models\Curso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        // Middleware de permisos
        $this->middleware('can:admin.asistencias.index')->only('index');
        $this->middleware('can:admin.asistencias.store')->only('store');
        $this->middleware('can:admin.asistencias.inasistencias')->only('show');
    }

    /**
     * Mostrar formulario de registro de asistencias
     */
    public function index()
    {
        $hoy = Carbon::now()->format('Y-m-d');

        // Obtener clases según el rol del usuario
        if (Auth::user()->hasRole(['admin', 'superAdmin'])) {
            // Admin ve todas las clases
            $clases = Clase::with(['curso', 'profesor.user', 'estudiantes'])
                ->whereDate('fecha_hora_inicio', '>=', now())
                ->orderBy('fecha_hora_inicio', 'asc')
                ->get();
        } else {
            // Profesor solo ve sus clases
            $clases = Clase::with(['curso', 'profesor.user', 'estudiantes'])
                ->whereDate('fecha_hora_inicio', '>=', now())
                ->whereHas('profesor', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->orderBy('fecha_hora_inicio', 'asc')
                ->get();
        }

        // Obtener asistencias ya registradas (indexadas por clase_id-estudiante_id)
        $asistencias = Asistencia::with('clase', 'estudiante')
            ->whereHas('clase', function($query) use ($hoy) {
                $query->whereDate('fecha_hora_inicio', $hoy);
            })
            ->get()
            ->keyBy(function($item) {
                return $item->clase_id . '-' . $item->estudiante_id;
            });

        return view('admin.asistencias.index', compact('clases', 'asistencias'));
    }

    /**
     * Registrar asistencias de una clase
     */
    public function store(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id',
            'asistencias' => 'required|array',
            'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
            'asistencias.*.estado' => 'required|in:presente,ausente,tardanza,excusado',
        ]);

        $clase = Clase::with('curso')->findOrFail($request->clase_id);
        
        // Calcular duración de la clase en horas
        $inicio = Carbon::parse($clase->fecha_hora_inicio);
        $fin = Carbon::parse($clase->fecha_hora_fin);
        $duracionHoras = $fin->diffInHours($inicio, true); // true para decimales

        DB::beginTransaction();
        
        try {
            foreach ($request->asistencias as $asistenciaData) {
                $estudianteId = $asistenciaData['estudiante_id'];
                $estado = $asistenciaData['estado'];

                // Crear o actualizar asistencia
                $asistencia = Asistencia::updateOrCreate(
                    [
                        'clase_id' => $clase->id,
                        'estudiante_id' => $estudianteId,
                    ],
                    [
                        'estado' => $estado,
                        'hora_registro' => now(),
                    ]
                );

                // Actualizar horas realizadas en estudiante_curso
                $this->actualizarHorasRealizadas(
                    $estudianteId, 
                    $clase->curso_id, 
                    $duracionHoras, 
                    $estado
                );
            }

            // Marcar clase como dictada
            $clase->update(['estado' => 'dictada']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asistencias registradas correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar estudiantes con inasistencias
     */
    public function show()
    {
        $query = Estudiante::select(
                'estudiantes.id',
                'estudiantes.nombres',
                'estudiantes.apellidos',
                'asistencias.id AS asistencia_id',
                'clases.titulo AS nombre_clase',
                'clases.fecha_hora_inicio',
                'clases.fecha_hora_fin',
                'asistencias.estado',
                'cursos.nombre AS nombre_curso'
            )
            ->join('asistencias', 'estudiantes.id', '=', 'asistencias.estudiante_id')
            ->join('clases', 'asistencias.clase_id', '=', 'clases.id')
            ->join('cursos', 'clases.curso_id', '=', 'cursos.id')
            ->where('asistencias.estado', 'ausente');

        // Si no es admin, filtrar por profesor
        if (!Auth::user()->hasRole(['admin', 'superAdmin'])) {
            $query->whereHas('clases.profesor', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $estudiantes = $query->orderBy('clases.fecha_hora_inicio', 'desc')->get();

        // Calcular horas de cada inasistencia
        foreach ($estudiantes as $estudiante) {
            $inicio = new \DateTime($estudiante->fecha_hora_inicio);
            $fin = new \DateTime($estudiante->fecha_hora_fin);
            $diff = $inicio->diff($fin);
            $estudiante->cant_horas = round($diff->h + ($diff->i / 60), 2);
        }

        return view('admin.asistencias.inasistencias', compact('estudiantes'));
    }

    /**
     * Justificar/Excusar una inasistencia
     */
    public function excusar(Request $request, $asistenciaId)
    {
        $request->validate([
            'observaciones' => 'nullable|string|max:500'
        ]);

        $asistencia = Asistencia::findOrFail($asistenciaId);
        
        $asistencia->update([
            'estado' => 'excusado',
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->back()->with('success', 'Inasistencia excusada correctamente');
    }

    /**
     * Actualizar horas realizadas del estudiante en el curso
     */
    private function actualizarHorasRealizadas($estudianteId, $cursoId, $horas, $estado)
    {
        // Verificar si el estudiante está inscrito en el curso
        $inscripcion = DB::table('estudiante_curso')
            ->where('estudiante_id', $estudianteId)
            ->where('curso_id', $cursoId)
            ->first();

        if (!$inscripcion) {
            // Crear inscripción si no existe
            DB::table('estudiante_curso')->insert([
                'estudiante_id' => $estudianteId,
                'curso_id' => $cursoId,
                'horas_realizadas' => 0,
                'estado' => 'activo',
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Solo sumar horas si asistió (presente o tardanza)
        if (in_array($estado, ['presente', 'tardanza'])) {
            DB::table('estudiante_curso')
                ->where('estudiante_id', $estudianteId)
                ->where('curso_id', $cursoId)
                ->increment('horas_realizadas', $horas);
        }
    }

    /**
     * Registrar asistencia rápida (para profesores desde la clase)
     */
    public function registrarRapido(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'estado' => 'required|in:presente,ausente,tardanza,excusado',
        ]);

        $asistencia = Asistencia::updateOrCreate(
            [
                'clase_id' => $request->clase_id,
                'estudiante_id' => $request->estudiante_id,
            ],
            // [
            //     'estado' => $request->estado,
            //     'hora_registro' => now(),
            // ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada',
            'asistencia' => $asistencia
        ]);
    }

    /**
     * Obtener estadísticas de asistencias de un estudiante
     */
    public function estadisticas($estudianteId)
    {
        $estudiante = Estudiante::findOrFail($estudianteId);

        $estadisticas = Asistencia::where('estudiante_id', $estudianteId)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->pluck('total', 'estado');

        $totalClases = $estadisticas->sum();
        
        $porcentajes = [
            'presente' => $totalClases > 0 ? round(($estadisticas->get('presente', 0) / $totalClases) * 100, 2) : 0,
            'ausente' => $totalClases > 0 ? round(($estadisticas->get('ausente', 0) / $totalClases) * 100, 2) : 0,
            'tardanza' => $totalClases > 0 ? round(($estadisticas->get('tardanza', 0) / $totalClases) * 100, 2) : 0,
            'excusado' => $totalClases > 0 ? round(($estadisticas->get('excusado', 0) / $totalClases) * 100, 2) : 0,
        ];

        return view('admin.asistencias.estadisticas', compact('estudiante', 'estadisticas', 'porcentajes', 'totalClases'));
    }
}