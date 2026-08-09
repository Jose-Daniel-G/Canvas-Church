{{-- resources/views/estudiante/calificaciones/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Mis Calificaciones')

@section('content_header')
    <h1>Mis Calificaciones</h1>
@stop

@section('content')
    <div class="container-fluid">
        {{-- Resumen por curso --}}
        <div class="row">
            @forelse($promedios as $cursoId => $datos)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header {{ $datos['aprobado'] ? 'bg-success' : 'bg-danger' }}">
                            <h3 class="card-title">{{ $datos['curso']->nombre }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="display-4">{{ number_format($datos['promedio'], 2) }}</h2>
                                <p class="text-muted">Promedio Final</p>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <strong>{{ $datos['total_calificaciones'] }}</strong>
                                    <p class="text-muted small mb-0">Evaluaciones</p>
                                </div>
                                <div class="col-6">
                                    <strong>{{ $datos['aprobado'] ? 'Aprobado' : 'Reprobado' }}</strong>
                                    <p class="text-muted small mb-0">Estado</p>
                                </div>
                            </div>

                            <div class="progress mt-3" style="height: 20px;">
                                <div class="progress-bar {{ $datos['aprobado'] ? 'bg-success' : 'bg-danger' }}" 
                                     style="width: {{ ($datos['promedio'] / 5) * 100 }}%">
                                    {{ number_format(($datos['promedio'] / 5) * 100, 0) }}%
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('estudiante.calificaciones.por-curso', $cursoId) }}" 
                               class="btn btn-primary btn-block">
                                <i class="fas fa-eye"></i> Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        No tienes calificaciones publicadas aún.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Tabla de todas las calificaciones --}}
        @if($calificaciones->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Historial de Calificaciones</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Curso</th>
                                <th>Concepto</th>
                                <th>Tipo</th>
                                <th class="text-center">Nota</th>
                                <th class="text-center">Porcentaje</th>
                                <th class="text-center">Aporte</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calificaciones as $calif)
                                <tr>
                                    <td>{{ $calif->fecha_calificacion->format('d/m/Y') }}</td>
                                    <td>{{ $calif->curso->nombre }}</td>
                                    <td>
                                        {{ $calif->concepto }}
                                        @if($calif->entrega)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-link"></i> Entrega digital
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($calif->tipo_evaluacion) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-{{ $calif->color }}">
                                            {{ number_format($calif->nota, 2) }}
                                        </strong>
                                        <small class="text-muted">/ {{ $calif->nota_maxima }}</small>
                                    </td>
                                    <td class="text-center">{{ $calif->porcentaje }}%</td>
                                    <td class="text-center">
                                        {{ number_format($calif->aporte_nota_final, 2) }}
                                    </td>
                                    <td>
                                        @if($calif->observaciones)
                                            <button type="button" 
                                                    class="btn btn-sm btn-info" 
                                                    data-toggle="modal" 
                                                    data-target="#observacionesModal{{ $calif->id }}">
                                                <i class="fas fa-comment"></i> Ver
                                            </button>

                                            {{-- Modal de observaciones --}}
                                            <div class="modal fade" id="observacionesModal{{ $calif->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Observaciones</h4>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $calif->observaciones }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Sin observaciones</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@stop

@section('css')
<style>
    .display-4 {
        font-weight: bold;
    }
    .card-header.bg-success,
    .card-header.bg-danger {
        color: white;
    }
</style>
@stop