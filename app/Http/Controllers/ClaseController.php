<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function __construct()
    {
        // Mismos roles que ya administran horarios (root, superAdmin, admin, secretaria)
        $this->middleware('can:admin.clases.create')->only('store');
        $this->middleware('can:admin.clases.edit')->only('edit', 'update');
        $this->middleware('can:admin.clases.destroy')->only('destroy');
    }

    public function store(Request $request)
    {
        $validated = $this->validateClase($request);

        $clase = Clase::create($validated);
        $clase->estudiantes()->sync($request->estudiantes ?? []);

        return redirect()->route('admin.home.show')
            ->with(['info' => 'Clase creada correctamente.', 'icon' => 'success']);
    }

    public function edit(Clase $clase)
    {
        $clase->load('estudiantes');

        return response()->json([
            'clase' => $clase,
            'estudiantesSeleccionados' => $clase->estudiantes->pluck('id'),
        ]);
    }

    public function update(Request $request, Clase $clase)
    {
        $validated = $this->validateClase($request);

        $clase->update($validated);
        $clase->estudiantes()->sync($request->estudiantes ?? []);

        return redirect()->route('admin.home.show')
            ->with(['info' => 'Clase actualizada correctamente.', 'icon' => 'success']);
    }

    public function destroy(Clase $clase)
    {
        $clase->delete();

        return redirect()->route('admin.home.show')
            ->with(['info' => 'Clase eliminada correctamente.', 'icon' => 'success']);
    }

    private function validateClase(Request $request): array
    {
        return $request->validate([
            'titulo' => 'required|string|max:255',
            'curso_id' => 'required|exists:cursos,id',
            'profesor_id' => 'required|exists:profesors,id',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date|after:fecha_hora_inicio',
            'aula' => 'nullable|string|max:255',
            'modalidad' => 'nullable|string|max:255',
            'link_virtual' => 'nullable|url|max:255',
            'estado' => 'required|in:programada,dictada,cancelada',
            'color' => 'nullable|string|max:20',
            'estudiantes' => 'nullable|array',
            'estudiantes.*' => 'exists:estudiantes,id',
        ]);
    }
}
