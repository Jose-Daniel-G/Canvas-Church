@extends('adminlte::page')

@section('title', 'Mis Calificaciones')

@section('content_header')
    <h1>
        <i class="fas fa-star"></i> Mis Calificaciones
    </h1>
@stop

@section('content')
    <div class="container-fluid">

        {{-- Información del Curso --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">
                    <i class="fas fa-book"></i> {{ $curso->codigo }} - {{ $curso->nombre }}
                </h3>
                <div class="card-tools">
                    <span class="badge badge-light">Período: {{ $curso->periodo }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon">
                                <i class="fas fa-trophy"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Mi Nota Final</span>
                                <span class="info-box-number">{{ number_format($estadisticas['nota_final'], 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Promedio Curso</span>
                                <span class="info-box-number">{{ number_format($estadisticas['promedio_curso'], 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Evaluaciones</span>
                                <span class="info-box-number">{{ $calificaciones->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon">
                                <i class="fas fa-percentage"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Porcentaje</span>
                                <span class="info-box-number">{{ $estadisticas['porcentaje_completado'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Desglose de Calificaciones por Tipo --}}
        <div class="row">
            @foreach($calificacionesPorTipo as $tipo => $califs)
                @php
                    $promedio = $califs->avg('nota');
                    $pesoTotal = $califs->sum('porcentaje');
                    $iconos = [
                        'tarea' => ['icono' => 'clipboard-list', 'color' => 'info'],
                        'quiz' => ['icono' => 'question-circle', 'color' => 'warning'],
                        'parcial' => ['icono' => 'file-alt', 'color' => 'primary'],
                        'examen' => ['icono' => 'graduation-cap', 'color' => 'danger'],
                        'proyecto' => ['icono' => 'project-diagram', 'color' => 'success'],
                    ];
                    $config = $iconos[$tipo] ?? ['icono' => 'star', 'color' => 'secondary'];
                @endphp

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-{{ $config['color'] }}">
                            <h3 class="card-title">
                                <i class="fas fa-{{ $config['icono'] }}"></i> 
                                {{ ucfirst($tipo) }}s ({{ $pesoTotal }}%)
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ ucfirst($tipo) }}</th>
                                        <th width="100" class="text-center">Nota</th>
                                        <th width="120" class="text-center">Peso</th>
                                        <th width="100" class="text-center">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($califs as $calif)
                                        <tr>
                                            <td>
                                                {{ $calif->concepto }}
                                                @if($calif->observaciones)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-comment"></i> 
                                                        {{ Str::limit($calif->observaciones, 50) }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <strong>{{ number_format($calif->nota, 2) }}</strong>
                                                <span class="text-muted">/ {{ $calif->nota_maxima }}</span>
                                            </td>
                                            <td class="text-center">{{ $calif->porcentaje }}%</td>
                                            <td class="text-center">
                                                <small>{{ $calif->fecha_calificacion->format('d/m/Y') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th>Promedio {{ ucfirst($tipo) }}s</th>
                                        <th class="text-center">{{ number_format($promedio, 2) }}</th>
                                        <th class="text-center">{{ $pesoTotal }}%</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mensaje si no hay calificaciones --}}
        @if($calificaciones->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Aún no tienes calificaciones publicadas en este curso.
            </div>
        @endif

    </div>
@stop