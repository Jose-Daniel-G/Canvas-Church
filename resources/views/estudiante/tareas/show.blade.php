{{-- resources/views/estudiante/tareas/show.blade.php --}}
@extends('adminlte::page')

@section('title', $tarea->nombre)

@section('content_header')
    <h1>{{ $tarea->nombre }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline mt-3">
                    <div class="card-header">
                        <a class="btn btn-link pl-0" href="{{ route('estudiante.tareas.index') }}">
                            <i class="fas fa-arrow-left"></i> Volver a tareas
                        </a>
                        <h3 class="card-title">
                            {{ $tarea->nombre }}
                        </h3>
                        <div class="card-tools">
                            <span class="badge {{ $tarea->badge_class }}">
                                {{ ucfirst($tarea->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fecha límite:</strong>
                                {{ $tarea->fecha_entrega->format('d \d\e F \d\e Y') }}
                            </div>
                            <div class="col-md-6 text-right">
                                @if ($tarea->estado === 'pendiente')
                                    <span class="text-danger">
                                        <i class="far fa-clock"></i>
                                        Faltan {{ $tarea->dias_restantes }}
                                        {{ $tarea->dias_restantes == 1 ? 'día' : 'días' }}
                                    </span>
                                @elseif($tarea->estado === 'atrasado')
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-triangle"></i> Atrasado
                                    </span>
                                @else
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> Entregado
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h5>Descripción de la tarea</h5>
                        <p>{{ $tarea->descripcion_tarea }}</p>

                        @if ($tarea->requisitos)
                            <h5 class="mt-4">Requisitos</h5>
                            {!! nl2br(e($tarea->requisitos)) !!}
                        @endif

                        @if ($tarea->criterios_evaluacion)
                            <h5 class="mt-4">Criterios de evaluación</h5>
                            {!! nl2br(e($tarea->criterios_evaluacion)) !!}
                        @endif

                        @if ($tarea->documentos->count() > 0)
                            <h5 class="mt-4">Recursos de apoyo</h5>
                            <div class="list-group mb-3">
                                @foreach ($tarea->documentos as $documento)
                                    <a href="{{ asset('storage/'.$documento->archivo) }}" target="_blank"
                                        class="list-group-item list-group-item-action">
                                        @php
                                            $extension = pathinfo($documento->ruta, PATHINFO_EXTENSION);
                                            $iconClass = match ($extension) {
                                                'pdf' => 'fas fa-file-pdf text-danger',
                                                'doc', 'docx' => 'fas fa-file-word text-primary', 
                                                default => 'fas fa-file text-secondary',
                                            };
                                        @endphp
                                        <i class="{{ $iconClass }}"></i> {{ $documento->titulo }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        @if ($tarea->entregas->isEmpty())
                            <h5 class="mt-4">Entrega de la tarea</h5>

                            <form action="{{ route('estudiante.entregas.store', $tarea) }}" method="POST"
                                enctype="multipart/form-data" id="formEntrega">
                                @csrf
                                <input type="hidden" name="tarea_id" value="{{ $tarea->id }}">

                                <div class="form-group">
                                    <label>Subir archivo</label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('archivo') is-invalid @enderror" id="taskFile"
                                            name="archivo" accept=".docx,.pdf,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="taskFile">
                                            Seleccionar archivo
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos aceptados: .docx, .pdf, .jpg, .png (máx. 50MB)
                                    </small>
                                    @error('archivo')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Comentarios adicionales (opcional)</label>
                                    <textarea class="form-control @error('comentario') is-invalid @enderror" name="comentario" rows="4"
                                        placeholder="Agrega cualquier comentario o nota para el instructor...">{{ old('comentario') }}</textarea>
                                    @error('comentario')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane"></i> Enviar tarea
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                                        <i class="fas fa-save"></i> Guardar borrador
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Historial de entregas --}}
                {{-- <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Historial de entregas</h3>
                    </div>
                    <div class="card-body">
                        @forelse($tarea->entregas as $entrega)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Entregado:</strong>
                                            {{ $entrega->created_at->format('d/m/Y H:i') }}
                                        </div>
                                        @if ($entrega->calificacion)
                                            <span class="badge badge-success">
                                                Calificación: {{ $entrega->calificacion }}/100
                                            </span>
                                        @else
                                            <span class="badge badge-warning">Pendiente de calificación</span>
                                        @endif
                                    </div>

                                    @if ($entrega->comentario)
                                        <p class="mt-2 mb-0">
                                            <strong>Comentario:</strong> {{ $entrega->comentario }}
                                        </p>
                                    @endif
                                    @if ($entrega->documentos->count() > 0)
                                        <p class="mt-2 mb-0"><strong>Archivos:</strong></p>
                                        <ul class="mb-0">
                                            @foreach ($entrega->documentos as $doc)
                                                <li>
                                                    <a href="{{ Storage::url($doc->ruta) }}" target="_blank">
                                                        {{ $doc->nombre }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($entrega->retroalimentacion)
                                        <div class="alert alert-info mt-3 mb-0">
                                            <strong>Retroalimentación del docente:</strong><br>
                                            {{ $entrega->retroalimentacion }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No hay entregas previas para esta tarea.</p>
                        @endforelse
                    </div>
                </div> --}}
            </div>
            {{-- <div class="col-4">
                <div class="card card-outline mt-3">
                    <div class="card-body">

                        <h5 class="mb-3">Tu progreso</h5>
                        <div class="text-center mb-3">
                            <div class="h1 text-bold">67%</div>
                            <div class="text-muted">Tareas completadas</div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Completadas</span>
                                <span class="fw-bold">2/3</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Promedio</span>
                                <span class="fw-bold">91.5</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Mejor calificación</span>
                                <span class="fw-bold text-success">95</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-outline mt-3">
                    <div class="card-body">
                        <h5 class="mb-3">Próximas fechas</h5>
                        <div class="mb-3">
                            <div class="fw-bold text-danger">25 Ene 2026</div>
                            <div class="small">Tarea 3: Portfolio Personal</div>
                        </div>
                        <div class="mb-3">
                            <div class="fw-bold">28 Ene 2026</div>
                            <div class="small">Examen Módulo 1</div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@stop

@section('js')
    <script>
        // Actualizar el nombre del archivo seleccionado
        document.getElementById('taskFile').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Seleccionar archivo ZIP';
            e.target.nextElementSibling.textContent = fileName;
        });

        function saveDraft() {
            alert('Funcionalidad de guardar borrador - Por implementar');
        }
    </script>
@stop
