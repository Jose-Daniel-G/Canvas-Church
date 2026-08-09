<?php

namespace App\Http\Controllers\Academico;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Models\Tarea;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    public function index(Tarea $tarea)
    {
        // Ver todas las entregas de una tarea
        $entregas = $tarea->entregas()->with('user')->get();

        return view('profesor.entregas.index', compact('tarea', 'entregas'));
    }

    public function store(Request $request)
    {
        $tarea = Tarea::findOrFail($request->tarea_id);
        // dd($tarea->toArray());

        $request->validate([
            'archivo' => 'required|file|mimes:docx,pdf,jpg,jpeg,png|max:51200',
            'comentario' => 'nullable|string',
        ]);

        $estudianteId = auth()->user()->estudiante->id;

        // Evitar doble entrega (respaldo a la restricción unique)
        if ($tarea->entregas()->where('estudiante_id', $estudianteId)->exists()) {
            return back()->withErrors([
                'archivo' => 'Ya enviaste esta tarea.',
            ]);
        }

        // Guardar archivo
        $rutaArchivo = $request->file('archivo')
            ->store('entregas/tarea_' . $tarea->id, 'public');

        Entrega::create([
            'tarea_id'       => $tarea->id,
            'estudiante_id'  => $estudianteId,
            'comentario'     => $request->comentario,
            'archivo'        => $rutaArchivo,
            'fecha_entrega'  => now(),
            'entrega_tardia' => now()->gt($tarea->fecha_limite),
            'estado'         => now()->gt($tarea->fecha_limite) ? 'tardia' : 'pendiente',
        ]);

        return back()->with('success', 'Entrega enviada correctamente');
    }


    public function calificar(Request $request, Entrega $entrega)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0',
            'comentario_profesor' => 'nullable|string',
        ]);

        // Validación lógica: no pasar del puntaje de la tarea
        if ($request->calificacion > $entrega->tarea->puntaje) {
            return back()->withErrors([
                'calificacion' => 'La calificación supera el puntaje máximo',
            ]);
        }

        $entrega->update([
            'calificacion' => $request->calificacion,
            'comentario_profesor' => $request->comentario_profesor,
        ]);

        return back()->with('success', 'Entrega calificada');
    }
}
