@extends('adminlte::page')

@section('title', 'Detalle de tarea')

@section('content')
<div class="container-fluid">

    <h3>{{ $tarea->titulo }}</h3>

    <p>{{ $tarea->descripcion_tarea }}</p>

    <p>
        <strong>Fecha límite:</strong> {{ $tarea->fecha_entrega ?? 'No definida' }} <br>
        <strong>Puntaje máximo:</strong> {{ $tarea->puntaje }}
    </p>

    {{-- DOCUMENTOS DEL PROFESOR --}}
    <h5>Documentos</h5>
    <ul>
        @foreach($tarea->documentos as $doc)
            <li>
                <a href="{{ asset('storage/'.$doc->archivo) }}" target="_blank">
                    {{ $doc->titulo }}
                </a>
            </li>
        @endforeach
    </ul>

    <hr>

    {{-- ENTREGAS --}}
    <h4>Entregas de estudiantes</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Fecha entrega</th>
                <th>Calificación</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tarea->entregas as $entrega)
            <tr>
                <td>{{ $entrega->estudiante->name }}</td>
                <td>{{ $entrega->fecha_entrega }}</td>
                <td>{{ $entrega->calificacion ?? 'Sin calificar' }}</td>
                <td>
                    <button class="btn btn-sm btn-primary"
                        data-toggle="modal"
                        data-target="#calificar{{ $entrega->id }}">
                        Calificar
                    </button>
                </td>
            </tr>

            {{-- MODAL CALIFICAR --}}
            <div class="modal fade" id="calificar{{ $entrega->id }}">
                <div class="modal-dialog">
                    <form method="POST"
                        action="{{ route('profesor.entregas.calificar', $entrega) }}">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Calificar entrega</h5>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Calificación</label>
                                    <input type="number"
                                        name="calificacion"
                                        class="form-control"
                                        max="{{ $tarea->puntaje }}"
                                        value="{{ $entrega->calificacion }}">
                                </div>

                                <div class="form-group">
                                    <label>Comentario</label>
                                    <textarea name="comentario_profesor"
                                        class="form-control"
                                        rows="3">{{ $entrega->comentario_profesor }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">
                    No hay entregas aún
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection
