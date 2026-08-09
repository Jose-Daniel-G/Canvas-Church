@extends('adminlte::page')

@section('title', 'Libro de Calificaciones')

@section('content_header')
    <h1><i class="fas fa-book"></i> Gestión de Calificaciones</h1>
@stop

@section('content')
    <div class="container-fluid">
        {{-- Selector de Curso --}}
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.profesor.calificaciones.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Cursos en su Horario:</label>
                            <select name="curso_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Seleccione un curso --</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                        {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->codigo }} - {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($cursoSeleccionado)
            <div class="card shadow">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Planilla: {{ $cursoSeleccionado->nombre }}</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped m-0" id="tabla-notas">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Estudiante</th>
                                    {{-- CABECERAS DINÁMICAS --}}
                                    @foreach ($tareasDelCurso as $tarea)
                                        <th class="text-center">
                                            {{ $tarea->titulo_tarea }} <br>
                                            <small class="badge badge-info">{{ $tarea->porcentaje }}%</small>
                                        </th>
                                    @endforeach
                                    <th class="text-center bg-gray-light">FINAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($estudiantes as $index => $estudiante)
                                    <tr>
                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">
                                            <strong>{{ $estudiante->user->name }}</strong>
                                        </td>

                                        {{-- INPUTS DINÁMICOS POR TAREA --}}
                                        @foreach ($tareasDelCurso as $tarea)
                                            <td class="text-center p-1" style="min-width: 130px;">
                                                @php
                                                    // Buscamos la única entrega que vincula a este alumno con esta tarea
                                                    $entrega = $estudiante->entregas->firstWhere(
                                                        'tarea_id',
                                                        $tarea->id,
                                                    );

                                                    $calificacion = $estudiante->calificaciones
                                                        ->where('concepto', $tarea->titulo_tarea)
                                                        ->first();
                                                @endphp

                                                {{-- Input para la nota --}}
                                                <input type="number"
                                                    name="notas[{{ $estudiante->id }}][{{ $tarea->id }}]"
                                                    class="form-control form-control-sm text-center input-nota mb-1"
                                                    step="0.1" min="0" max="{{ $tarea->puntaje }}"
                                                    value="{{ $calificacion->nota ?? '' }}"
                                                    data-peso="{{ $tarea->porcentaje }}" data-max="{{ $tarea->puntaje }}">

                                                @if ($entrega)
                                                    {{-- Botón único de revisión --}}
                                                    <a href="{{ route('admin.profesor.calificaciones.revision', $entrega->id) }}"
                                                        class="btn btn-xs btn-primary btn-block shadow-sm">
                                                        <i class="fas fa-file-alt"></i> Ver Entrega
                                                    </a>
                                                    @if ($entrega->entrega_tardia)
                                                        <small class="text-danger" style="font-size: 0.6rem;">
                                                            <i class="fas fa-clock"></i> Entregada tarde
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary disabled"
                                                        style="font-size: 0.65rem; opacity: 0.6;">
                                                        Sin actividad
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach

                                        <td class="text-center align-middle">
                                            <span class="badge badge-primary nota-final"
                                                id="final-{{ $estudiante->id }}">0.0</span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($tareasDelCurso) + 4 }}" class="text-center">No hay
                                            estudiantes.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success float-right" onclick="guardarTodo()">
                        <i class="fas fa-save"></i> Guardar Planilla
                    </button>
                </div>
            </div>
        @endif
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            calcularFinales();
            $('.input-nota').on('input', calcularFinales);
        });

        function calcularFinales() {
            $('#tabla-notas tbody tr').each(function() {
                let row = $(this);
                let totalPonderado = 0;
                let sumaPesos = 0;

                row.find('.input-nota').each(function() {
                    let nota = parseFloat($(this).val()) || 0;
                    let peso = parseFloat($(this).data('peso')) || 0;
                    let max = parseFloat($(this).data('max')) || 100;

                    // Normalizamos la nota a base 5.0 para el cálculo final si es necesario
                    // O simplemente sumamos (nota * (peso/100))
                    totalPonderado += (nota * (peso / 100));
                    sumaPesos += peso;
                });

                let badge = row.find('.nota-final');
                badge.text(totalPonderado.toFixed(2));

                if (totalPonderado >= 3.0) {
                    badge.removeClass('badge-danger').addClass('badge-success');
                } else {
                    badge.removeClass('badge-success').addClass('badge-danger');
                }
            });
        }

        function guardarTodo() {
            // ... lógica de AJAX que ya tienes ...
        }
    </script>
@stop
