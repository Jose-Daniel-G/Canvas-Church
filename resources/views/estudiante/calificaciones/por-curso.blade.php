{{-- resources/views/estudiante/calificaciones/por-curso.blade.php --}}
@extends('adminlte::page')

@section('title', 'Calificaciones - ' . $curso->nombre)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $curso->nombre }}</h1>
        <a href="{{ route('estudiante.calificaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        {{-- Resumen General --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $estadisticas['total_evaluaciones'] }}</h3>
                        <p>Evaluaciones</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box {{ $estadisticas['promedio_ponderado'] >= 3.0 ? 'bg-success' : 'bg-danger' }}">
                    <div class="inner">
                        <h3>{{ number_format($estadisticas['promedio_ponderado'], 2) }}</h3>
                        <p>Promedio Final</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $estadisticas['aprobadas'] }}</h3>
                        <p>Aprobadas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $estadisticas['reprobadas'] }}</h3>
                        <p>Reprobadas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calificaciones por tipo --}}
        <div class="row">
            @foreach($porTipo as $tipo => $califs)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-graduation-cap"></i>
                                {{ ucfirst($tipo) }}
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th class="text-center">Nota</th>
                                        <th class="text-center">%</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($califs as $calif)
                                        <tr>
                                            <td>{{ $calif->concepto }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $calif->color }}">
                                                    {{ number_format($calif->nota, 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $calif->porcentaje }}%</td>
                                            <td>{{ $calif->fecha_calificacion->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tabla detallada --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle de Calificaciones</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Tipo</th>
                            <th class="text-center">Nota</th>
                            <th class="text-center">Peso</th>
                            <th class="text-center">Aporte</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($calificaciones as $calif)
                            <tr>
                                <td>{{ $calif->fecha_calificacion->format('d/m/Y') }}</td>
                                <td>
                                    {{ $calif->concepto }}
                                    @if($calif->entrega)
                                        <br>
                                        <a href="{{ route('estudiante.tareas.show', $calif->entrega->tarea_id) }}" 
                                           class="badge badge-primary">
                                            <i class="fas fa-file"></i> Ver entrega
                                        </a>
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
                                    / {{ $calif->nota_maxima }}
                                </td>
                                <td class="text-center">{{ $calif->porcentaje }}%</td>
                                <td class="text-center">
                                    {{ number_format($calif->aporte_nota_final, 2) }}
                                </td>
                                <td>
                                    @if($calif->observaciones)
                                        {{ Str::limit($calif->observaciones, 50) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No hay calificaciones registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop