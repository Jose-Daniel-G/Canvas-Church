<?php

namespace App\Http\Controllers\Academico;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    public function __construct()
    {  // Solo los que tengan el permiso pueden acceder a estas acciones
        // $this->middleware('can:admin.cursos.index')->only('index');
        // $this->middleware('can:admin.cursos.create')->only('create', 'store');
        // $this->middleware('can:admin.cursos.edit')->only('edit', 'update');
        // $this->middleware('can:admin.cursos.destroy')->only('destroy');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['superAdmin', 'admin', 'root'])) {
            $cursos = Curso::all();
        } elseif ($user->profesor) {
            $cursos = $user->profesor->cursos;
        } else {
            $cursos = $user->estudiante->cursos;
        }

        return view('admin.cursos.index', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:cursos',
            'nombre' => 'required',
            'periodo' => 'required|string',
            'horas_requeridas' => 'required|integer|min:1',
            'estado' => 'required|in:0,1',
            'descripcion' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('openModal', 'createCursoModal');
        }
        Curso::create($request->all()); // Crear un nuevo curso

        return redirect()->route('admin.cursos.index')->with(['toast' => 2, 'title' => 'Exito', 'info' => 'Curso registrado correctamente.', 'icon' => 'success']);
    }

    public function show(Curso $curso)
    {
        $user = Auth::user();
        if($user->estudiante){
           $curso = auth()->user()->estudiante->cursos()->first();

        }
        // Cargar todas las relaciones necesarias
        $curso->load([
            'objetivos',
            'bibliografias',
            'documentos',
            'politicas',
            'calendarioEventos',
        ]);
        if ($user->hasRole('estudiante')) {
            $estaAsignado = $curso->estudiantes()
                ->where('user_id', $user->id)
                ->exists();

            if (!$estaAsignado) {
                abort(403, 'No tienes acceso a este curso');
            }
        }

        return view('admin.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $curso->load([
            'objetivos',
            'bibliografias',
            'documentos',
            'politicas',
            'calendarioEventos',
        ]);

        return view('admin.cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'periodo' => 'required|string',
            'codigo' => 'required|string',
        ]);
        // dd($request->all());
        DB::transaction(function () use ($request, $curso) {
            // 1️⃣ Actualizar curso
            $curso->update([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'periodo' => $request->periodo,
            ]);

            // 2️⃣ Objetivo general
            $curso->objetivos()->updateOrCreate(
                ['tipo' => 'general'],
                ['descripcion_obj' => $request->objetivo_general]
            );

            // 3️⃣ Objetivos específicos
            if ($request->filled('objetivos_especificos')) {
                $curso->objetivos()->where('tipo', 'especifico')->delete();

                foreach (json_decode($request->objetivos_especificos, true) as $desc) {
                    $curso->objetivos()->create([
                        'tipo' => 'especifico',
                        'descripcion_obj' => $desc,
                    ]);
                }
            }

            // 4️⃣ Bibliografías
            foreach ($request->bibliografias ?? [] as $biblio) {
                if (isset($biblio['id'])) {
                    $curso->bibliografias()->where('id', $biblio['id'])->update([
                        'titulo' => $biblio['titulo'],
                        'autor' => $biblio['autor'] ?? null,
                        'tipo' => $biblio['tipo'],
                        'url' => $biblio['url'] ?? null,
                    ]);
                } else {
                    $curso->bibliografias()->create($biblio);
                }
            }

            // 5️⃣ Calendario
            if ($request->filled('calendario_json')) {
                $curso->calendarioEventos()->delete();

                $eventos = json_decode($request->calendario_json, true);

                if (is_array($eventos)) {
                    foreach ($eventos as $evento) {
                        if (isset($evento['fecha']) && isset($evento['evento']) && isset($evento['tipo'])) {
                            $curso->calendarioEventos()->create([
                                'fecha' => $evento['fecha'],
                                'titulo' => $evento['evento'],
                                'tipo' => $evento['tipo'],
                            ]);
                        }
                    }
                }
            }

            // 6️⃣ Políticas
            if ($request->filled('politicas_json')) {
                // Eliminar políticas existentes
                $curso->politicas()->delete();

                // Crear nuevas políticas
                $politicas = json_decode($request->politicas_json, true);
                foreach ($politicas as $politica) {
                    $curso->politicas()->create([
                        'titulo_politica' => $politica['titulo'],
                        'contenido' => $politica['contenido'],
                    ]);
                }
            }
        });

        return back()->with('success', 'Curso actualizado con éxito');
    }

    public function completados()
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['superAdmin', 'admin', 'secretaria', 'profesor'])) {
            $cursosEstudiantes = Estudiante::with(['cursos' => function ($q) {
                $q->whereColumn(
                    'estudiante_curso.horas_realizadas',
                    '>=',
                    'cursos.horas_requeridas'
                );
            }])->get();

            return view('admin.content_cursos.partials.tasks.completados_all', compact('cursosEstudiantes'));
        }

        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return back()->with('error', 'No se encontró un registro asociado al usuario.');
        }

        return view('admin.content_cursos.completados', [
            'cursosCompletados' => $estudiante->cursosCompletados()->get(),
            'cursosEnProgreso' => $estudiante->cursosEnProgreso()->get(),
        ]);
    }

    public function estadisticas()
    {
        $cursosEstudiantes = DB::table('cursos')
            ->join('estudiante_curso', 'cursos.id', '=', 'estudiante_curso.curso_id')
            ->join('estudiantes', 'estudiante_curso.estudiante_id', '=', 'estudiantes.id')
            ->select(
                'estudiantes.id as estudiante_id',
                DB::raw("CONCAT(estudiantes.nombres, ' ', estudiantes.apellidos) as estudiante_nombre"),
                'cursos.id as curso_id',
                'cursos.nombre as curso_nombre',
                'cursos.horas_requeridas',
                'estudiante_curso.horas_realizadas',
                'estudiante_curso.fecha_realizacion'
            )
            ->orderBy('estudiantes.id')
            ->get();

        $cursosCompletados = $cursosEstudiantes->filter(fn ($c) => $c->horas_realizadas >= $c->horas_requeridas);
        $cursosEnProgreso = $cursosEstudiantes->filter(fn ($c) => $c->horas_realizadas < $c->horas_requeridas);

        return view('admin.cursos.estadisticas', compact('cursosEstudiantes', 'cursosCompletados', 'cursosEnProgreso'));
    }

    public function destroy(Curso $curso)
    {
        // if ($curso->user) {  $curso->user->delete(); } // Si existe un usuario asociado, eliminarlo

        $curso->delete(); // Eliminar el curso

        // return back()->with('success', 'Curso eliminado');
        return redirect()->route('admin.cursos.index')
            ->with(['title' => 'Exito', 'info' => 'El curso se eliminó con éxito', 'icon' => 'success']);
    }

    public function toggleStatus($id) // DEACTIVATE
    {
        $curso = Curso::findOrFail($id);
        $curso->estado = !$curso->estado;
        $curso->save();

        return redirect()->back()->with(['toast' => 2, 'info' => 'Estado del usuario actualizado.']);
    }

    public function obtenerCursos($estudianteId)
    {
        $estudiante = Estudiante::with('cursos')->findOrFail($estudianteId);

        return response()->json($estudiante->cursos);
    }

    public function quemada()
    {
        return view('estudiante.tareas.show');
    }

    public function objetivos(Curso $curso)
    {
        return view('cursos.show', [
            'curso' => $curso,
            'seccion' => 'objetivos',
            'objetivos' => $curso->objetivos,
        ]);
    }
}
