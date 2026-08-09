<?php

namespace App\Http\Controllers\Academico\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\TareaDocumento;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    // La protección de acceso vive en routes/admin.php (middleware 'role:profesor'
    // aplicado al grupo de rutas 'profesor/tareas'), igual que en Calificaciones.

    public function index()
    {
        $user = Auth::user();
        $profesor = $user->profesor;
        // dump($user->toArray());
        // dd($profesor);
        // dd($profesor->cursos);
        // Obtener cursos del profesor
        $cursos = $profesor->cursos;

        if ($cursos->isEmpty()) {
            return redirect()->route('admin.home')->with([
                'swal' => '1',
                'info' => 'No tiene cursos asignados.',
                'icon' => 'warning',
            ]);
        }

        // Obtener todas las tareas de los cursos del profesor
        $tareas = Tarea::with(['curso', 'entregas'])
            ->whereHas(
                'curso.profesores',
                fn($q) => $q->where('profesor_id', $profesor->id)
            )
            ->latest('fecha_entrega')
            ->paginate(15);

        // 👉 Validación: el profesor no tiene tareas
        if ($tareas->isEmpty()) {
            return view('profesor.tareas.index', compact('cursos', 'tareas'))
                ->with([
                    'swal' => '1',
                    'info' => 'Aún no tiene tareas registradas.',
                    'icon' => 'info',
                ]);
        }
        // dd($tareas);
        return view('profesor.tareas.index', compact('cursos', 'tareas'));
    }

    public function create()
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        // Obtener cursos del profesor
        $cursos = $profesor->cursos;

        if ($cursos->isEmpty()) {
            return redirect()->back()->with([
                'swal' => '1',
                'info' => 'No tiene cursos asignados. Contacte al administrador.',
                'icon' => 'warning',
            ]);
        }

        return view('profesor.tareas.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'tipo' => 'required|in:tarea,quiz,examen,proyecto,foro',
            'titulo_tarea' => 'required|string|max:255',
            'descripcion_tarea' => 'required|string',
            'fecha_entrega' => 'required|date',
            'puntaje' => 'required|numeric|min:0|max:100',
            'documentos.*' => 'nullable|file|max:51200',
        ]); 
        // ]);
        $user = Auth::user();
        // Validamos existencia de usuario y profesor ANTES de usar la propiedad
        if (!$user || !$user->profesor) {
            return redirect()->back()->with(['swal' => '1', 'info' => 'No eres un profesor válido.', 'icon' => 'error']);
        }

        $profesor = $user->profesor;
        if (!$profesor->cursos()->where('cursos.id', $request->curso_id)->exists()) {
            return redirect()->back()->with(['swal' => '1', 'info' => 'Sin acceso a este curso.', 'icon' => 'error']);
        }

        try {
            \DB::beginTransaction();

            // Creamos la tarea quitando la clave 'documentos' del array
            $tarea = Tarea::create(collect($validate)->except('documentos')->toArray());

            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('tareas/documentos', 'public');

                        // Esto fallaba porque el MODELO no tenía el $fillable
                        TareaDocumento::create([
                            'tarea_id' => $tarea->id,
                            'titulo'   => $file->getClientOriginalName(),
                            'archivo'  => $path,
                            'tipo'     => $file->getClientOriginalExtension(),
                        ]);
                    }
                }
            }

            \DB::commit();
            return redirect()->route('admin.profesor.tareas.index')->with(['swal' => '1', 'info' => 'Tarea creada.', 'icon' => 'success']);
        } catch (\Exception $e) {
            \DB::rollBack();
            // El error 1364 morirá aquí y te dirá exactamente por qué
            return redirect()->back()->withInput()->with([
                'swal' => '1',
                'info' => 'Error: ' . $e->getMessage(),
                'icon' => 'error',
            ]);
        }
    }

    /**
     * Ver detalle de tarea
     */
    public function show(Tarea $tarea)
    {
        $profesor = Auth::user()->profesor;

        abort_unless(
            $profesor->cursos->contains($tarea->curso_id),
            403,
            'No tienes acceso a esta tarea.'
        );

        $tarea->load(['curso', 'documentos', 'entregas.user']);

        return view('profesor.tareas.show', compact('tarea'));
    }
    /**
     * Editar tarea
     */
    public function edit(Tarea $tarea)
    {
        try {
            $user = Auth::user();

            $profesor = $user->profesor;

            // Comprobamos si el profesor es dueño del curso de esta tarea
            if (!$profesor->cursos->contains($tarea->curso_id)) {
                return redirect()->route('profesor.tareas.index')->with([
                    'swal' => '1',
                    'info' => 'No tienes permisos para editar esta tarea.',
                    'icon' => 'error'
                ]);
            }

            // Traemos los cursos para el <select> de la vista
            $cursos = $profesor->cursos;
            
            return view('profesor.tareas.edit', compact('tarea', 'cursos'));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'swal' => '1',
                'info' => 'Error al cargar edición: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }
    public function update(Request $request, Tarea $tarea)
    {
        $profesor = Auth::user()->profesor;

        abort_unless(
            $profesor->cursos->contains($tarea->curso_id),
            403
        );

        $data = $request->validate([
            'titulo_tarea' => 'required|string|max:255',
            'descripcion_tarea' => 'required|string',
            'fecha_entrega' => 'required|date',
            'puntaje' => 'required|numeric|min:0|max:100',
        ]);

        $tarea->update($data);

        return redirect()->route('profesor.tareas.show', $tarea)->with([
            'swal' => '1',
            'info' => 'Tarea actualizada.',
            'icon' => 'success',
        ]);
    }

    public function destroy(Tarea $tarea)
    {
        $profesor = Auth::user()->profesor;

        abort_unless(
            $profesor->cursos->contains($tarea->curso_id),
            403
        );
        DB::transaction(function () use ($tarea) {
            // Borrar archivos físicos
            foreach ($tarea->documentos as $doc) {
                Storage::disk('public')->delete($doc->archivo);
            }

            $tarea->delete();
        });

        return back()->with([
            'swal' => '1',
            'info' => 'Tarea eliminada.',
            'icon' => 'success',
        ]);
    }
}
