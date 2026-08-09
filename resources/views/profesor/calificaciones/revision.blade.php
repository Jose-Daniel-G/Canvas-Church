@extends('adminlte::page')

@section('title', 'Revisar Entrega')

@section('content_header')
    <h1><i class="fas fa-search"></i> Revisando: {{ $entrega->tarea->titulo_tarea }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Lado Izquierdo: El Contenido --}}
        <div class="col-md-8">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Estudiante: <strong>{{ $entrega->estudiante->user->name }}</strong></h3>
                </div>
                <div class="card-body">
                    @if($entrega->texto_entrega)
                        <label>Respuesta de texto:</label>
                        <div class="p-3 bg-light border rounded mb-4">
                            {!! nl2br(e($entrega->texto_entrega)) !!}
                        </div>
                    @endif

                    @if($entrega->archivo)
                        <label>Archivo adjunto:</label>
                        <div class="attachment-block clearfix">
                            <i class="fas fa-file-pdf fa-3x text-danger float-left mr-3"></i>
                            <div class="attachment-pushed">
                                <h4 class="attachment-heading">
                                    <a href="{{ asset('storage/' . $entrega->archivo) }}" target="_blank">
                                        {{ basename($entrega->archivo) }}
                                    </a>
                                </h4>
                                <div class="attachment-text">
                                    <a href="{{ asset('storage/' . $entrega->archivo) }}" download class="btn btn-sm btn-default mt-2">
                                        <i class="fas fa-download"></i> Descargar para revisar
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Opcional: Visor de PDF integrado --}}
                        @if(Str::endsWith($entrega->archivo, '.pdf'))
                            <iframe src="{{ asset('storage/' . $entrega->archivo) }}" width="100%" height="500px"></iframe>
                        @endif
                    @else
                        <div class="alert alert-warning">No se adjuntaron archivos.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Lado Derecho: Calificación --}}
        <div class="col-md-4">
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Calificar</h3>
                </div>
                <form action="{{ route('admin.profesor.calificaciones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="entrega_id" value="{{ $entrega->id }}">
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nota (Máx: {{ $entrega->tarea->puntaje }})</label>
                            <input type="number" name="nota" class="form-control form-control-lg" 
                                   step="0.1" min="0" max="{{ $entrega->tarea->puntaje }}"
                                   value="{{ optional($entrega->calificacion)->nota }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="5">{{ optional($entrega->calificacion)->observaciones }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block">Guardar Calificación</button>
                        <a href="{{ route('admin.profesor.calificaciones.index', ['curso_id' => $entrega->tarea->curso_id]) }}" 
                           class="btn btn-default btn-block">Volver al Libro</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop