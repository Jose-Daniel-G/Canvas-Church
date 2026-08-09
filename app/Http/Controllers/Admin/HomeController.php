<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Config;  // Usa un alias para el modelo Clase
use App\Models\Curso;
use App\Models\Entrega;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Profesor;
use App\Models\Secretaria;
use App\Models\User;
use App\Notifications\PostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['message_landing_page']); // Aplica el middleware 'auth' a todos los métodos excepto 'landing_page'
        // $this->middleware('can:admin.show_reservas')->only('show');
    }

    public function index()
    {
        $total_usuarios = User::count();
        $total_secretarias = Secretaria::count();
        $total_estudiantes = Estudiante::count();

        $total_profesores = Profesor::count();
        $total_horarios = Horario::count();
        $total_clases = Clase::count();
        $total_configuraciones = Config::count();
        $total_cursos = Auth()->user()->profesor ? Auth()->user()->profesor->cursos->count() : Curso::count();
        $total_agendas = 0; // Módulo de reservas aún no implementado (ver resources/views/admin/no-enProyecto)

        if (!Auth::user()->estudiante) {
            $data = $this->handleStaffDashboard();
            extract($data);

            $role = 'admin';

            $esProfesor = false;
            $misCursos = collect();
            $proximasClases = collect();
            $totalMisEstudiantes = 0;
            $entregasPendientes = 0;

            if (Auth::user()->profesor) {
                $esProfesor = true;
                $profesorData = $this->handleProfesorDashboard(Auth::user()->profesor);
                extract($profesorData);
            }

            return view('admin.index', compact('total_usuarios', 'total_cursos', 'total_secretarias', 'total_estudiantes', 'total_profesores', 'total_horarios', 'total_clases', 'total_agendas', 'cursosDisponibles', 'profesorSelect', 'total_configuraciones', 'role', 'esProfesor', 'misCursos', 'proximasClases', 'totalMisEstudiantes', 'entregasPendientes'));
        } else {
            $estudianteId = Auth::user()->estudiante->id;
            $cursos = Auth::user()->estudiante->cursos;
            $data = $this->handleClientRole($estudianteId);
            extract($data);

            $esProfesor = false;
            $misCursos = collect();
            $proximasClases = collect();
            $totalMisEstudiantes = 0;
            $entregasPendientes = 0;

            return view('admin.index', compact('total_usuarios', 'total_secretarias', 'total_estudiantes', 'total_cursos', 'total_profesores', 'total_horarios', 'total_clases', 'total_agendas', 'cursos', 'profesorSelect', 'cursosDisponibles', 'total_configuraciones', 'esProfesor', 'misCursos', 'proximasClases', 'totalMisEstudiantes', 'entregasPendientes'));
        }
    }

    public function show()
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['superAdmin', 'admin', 'secretaria'])) {
            $clases = Clase::with(['profesor', 'curso', 'estudiantes.user'])->orderByDesc('fecha_hora_inicio')->get();
        } elseif ($user->hasRole('estudiante')) {
            if (!$user->estudiante) {
                abort(403, 'El usuario no tiene perfil de estudiante.');
            }

            $clases = Clase::whereHas('estudiantes', function ($q) use ($user) {
                $q->where('estudiante_id', $user->estudiante->id);
            })
            ->with(['profesor', 'curso', 'estudiantes.user'])
            ->orderByDesc('fecha_hora_inicio')
            ->get();
        } else {
            $clases = collect();
        }

        $cursos = Curso::select('id', 'nombre')->orderBy('nombre')->get();
        $profesores = Profesor::select('id', 'nombres', 'apellidos')->orderBy('nombres')->get();
        $estudiantesDisponibles = Estudiante::select('id', 'nombres', 'apellidos')->orderBy('nombres')->get();

        return view('admin.home.show', compact('clases', 'cursos', 'profesores', 'estudiantesDisponibles'));
    }

    public function show_reserva_profesores() // calendar
    {
        try {
            $user = Auth::user();

            // Ventana de fechas razonable para el calendario en vivo: 1 mes atrás y 3 meses adelante.
            // Evita traer el historial completo de clases (que crece indefinidamente) en cada carga.
            $desde = now()->subMonth()->startOfDay();
            $hasta = now()->addMonths(3)->endOfDay();

            $query = Clase::with(['profesor', 'curso', 'estudiantes.user'])
                ->whereBetween('fecha_hora_inicio', [$desde, $hasta]);

            // 1️⃣ Roles administrativos → ven todo
            if ($user->hasAnyRole(['superAdmin', 'admin', 'secretaria'])) {
                $clases = $query->get();
            }
            // 2️⃣ Estudiante → solo sus reservas
            elseif ($user->estudiante) {
                $clases = $query->whereHas('estudiantes', function ($q) use ($user) {
                    $q->where('estudiantes.user_id', $user->id);
                })->get();
            }
            // 3️⃣ Profesor → solo sus clases
            elseif ($user->profesor) {
                $clases = $query->where('profesor_id', $user->profesor->id)->get();
            } else {
                $clases = collect();
            }

            // Formatear como eventos de FullCalendar (title, start, end, color, extendedProps)
            $eventos = $clases->map(function (Clase $clase) {
                return [
                    'id' => $clase->id,
                    'title' => $clase->titulo,
                    'start' => $clase->fecha_hora_inicio,
                    'end' => $clase->fecha_hora_fin,
                    'color' => $clase->color,
                    'extendedProps' => [
                        'profesor' => $clase->profesor ? [
                            'nombres' => $clase->profesor->nombres,
                            'apellidos' => $clase->profesor->apellidos,
                        ] : null,
                        'curso' => $clase->curso->nombre ?? null,
                        'estudiante' => optional($clase->estudiantes->first())->only(['nombres', 'apellidos']),
                    ],
                ];
            });

            return response()->json($eventos);
        } catch (\Exception $exception) {
            \Log::error('Error al cargar el calendario de clases: '.$exception->getMessage());

            return response()->json(['mensaje' => 'Error al cargar el calendario.'], 500);
        }
    }

    public function message_landing_page(Request $request)
    {
        $valid[] = $request->validate([
            'title' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        // para depuración
        // dd($valid);

        Notification::route('mail', 'destino@tudominio.com')->notify(
            new PostNotification($request->title, $request->email, $request->phone, $request->message)
        );
        // new PostNotification($valid[]));

        return back()->with('success', '✅ Tu mensaje fue enviado correctamente.');
    }

    /**
     * Datos personalizados para un profesor: sus cursos, próximas clases,
     * cuántos estudiantes tiene a cargo y cuántas entregas le faltan por calificar.
     */
    private function handleProfesorDashboard(Profesor $profesor): array
    {
        $misCursos = $profesor->cursos()->select('cursos.id', 'cursos.nombre')->get();

        $totalMisEstudiantes = $misCursos->isEmpty()
            ? 0
            : DB::table('estudiante_curso')
                ->whereIn('curso_id', $misCursos->pluck('id'))
                ->distinct('estudiante_id')
                ->count('estudiante_id');

        $proximasClases = Clase::with('curso')
            ->where('profesor_id', $profesor->id)
            ->where('fecha_hora_inicio', '>=', now())
            ->orderBy('fecha_hora_inicio')
            ->limit(5)
            ->get();

        $entregasPendientes = Entrega::whereDoesntHave('calificacion')
            ->whereHas('tarea.curso.profesores', function ($q) use ($profesor) {
                $q->where('profesors.id', $profesor->id);
            })
            ->count();

        return [
            'misCursos' => $misCursos,
            'totalMisEstudiantes' => $totalMisEstudiantes,
            'proximasClases' => $proximasClases,
            'entregasPendientes' => $entregasPendientes,
        ];
    }

    private function handleStaffDashboard()
    {
        $cursosDisponibles = Curso::all();
        $profesorSelect = DB::table('profesors')
            ->join('horario_profesor_curso', 'horario_profesor_curso.profesor_id', '=', 'profesors.id')
            ->join('horarios', 'horario_profesor_curso.horario_id', '=', 'horarios.id')
            ->join('cursos', 'horario_profesor_curso.curso_id', '=', 'cursos.id') // Usamos la tabla intermedia
            ->join('estudiante_curso', 'cursos.id', '=', 'estudiante_curso.curso_id')
            ->join('estudiantes', 'estudiante_curso.estudiante_id', '=', 'estudiantes.id')
            ->join('users', 'estudiantes.user_id', '=', 'users.id')
            ->select(
                'profesors.id',
                'profesors.nombres',
                'profesors.apellidos',
                DB::raw('GROUP_CONCAT(DISTINCT cursos.nombre ORDER BY cursos.nombre SEPARATOR ", ") as cursos')
            )
            ->groupBy('profesors.id', 'profesors.nombres', 'profesors.apellidos')
            ->limit(100)
            ->get();

        return [
            'profesorSelect' => $profesorSelect,
            'cursosDisponibles' => $cursosDisponibles,
        ];
    }

    private function handleClientRole($estudianteId)
    {
        $profesorSelect = DB::table('profesors')
            ->join('horario_profesor_curso', 'horario_profesor_curso.profesor_id', '=', 'profesors.id')
            ->join('horarios', 'horario_profesor_curso.horario_id', '=', 'horarios.id')
            ->join('cursos', 'horario_profesor_curso.curso_id', '=', 'cursos.id') // Usamos la tabla intermedia
            ->join('estudiante_curso', 'cursos.id', '=', 'estudiante_curso.curso_id')
            ->join('estudiantes', 'estudiante_curso.estudiante_id', '=', 'estudiantes.id')
            ->join('users', 'estudiantes.user_id', '=', 'users.id')
            ->where('users.id', Auth::id())
            ->select(
                'profesors.id',
                'profesors.nombres',
                'profesors.apellidos',
                DB::raw('GROUP_CONCAT(DISTINCT cursos.nombre ORDER BY cursos.nombre SEPARATOR ", ") as cursos')
            )
            ->groupBy('profesors.id', 'profesors.nombres', 'profesors.apellidos')
            ->limit(100)
            ->get();

        $total_cursos = DB::table('estudiante_curso')
            ->join('cursos', 'estudiante_curso.curso_id', '=', 'cursos.id')
            ->where('estudiante_curso.estudiante_id', $estudianteId)
            ->whereColumn('estudiante_curso.horas_realizadas', '>=', 'cursos.horas_requeridas')
            ->count();

        if ($estudianteId) {
            $cursosDisponibles = Curso::whereHas('estudiantes', function ($q) use ($estudianteId) {    // Obtenemos cursos del estudiante que aún no están completados
                $q->where('estudiante_id', $estudianteId)
                    ->whereColumn('estudiante_curso.horas_realizadas', '<', 'cursos.horas_requeridas');
            })->get();
        } else {
            $cursosDisponibles = Curso::all();
        }

        return [
            'profesorSelect' => $profesorSelect,
            'total_cursos' => $total_cursos,
            'cursosDisponibles' => $cursosDisponibles,
        ];
    }
}
