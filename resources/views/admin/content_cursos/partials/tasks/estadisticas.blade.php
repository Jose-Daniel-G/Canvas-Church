@extends('adminlte::page')

@section('title', 'Estadísticas de Asistencia')

@section('content_header') <h1 class="text-primary">
📊 Estadísticas de Asistencia </h1> <p class="text-muted">
Estudiante: <strong>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</strong> </p>
@stop

@section('content')

<div class="row">
    {{-- Total de clases --}}
    <div class="col-md-12 mb-3">
        <div class="alert alert-info">
            <strong>Total de clases registradas:</strong> {{ $totalClases }}
        </div>
    </div>
</div>

<div class="row">
    {{-- PRESENTE --}}
    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Presente</span>
                <span class="info-box-number">
                    {{ $estadisticas->get('presente', 0) }}
                </span>
                <span class="progress-description">
                    {{ $porcentajes['presente'] }} %
                </span>
            </div>
        </div>
    </div>

{{-- AUSENTE --}}
<div class="col-md-3">
    <div class="info-box bg-danger">
        <span class="info-box-icon"><i class="fas fa-times"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Ausente</span>
            <span class="info-box-number">
                {{ $estadisticas->get('ausente', 0) }}
            </span>
            <span class="progress-description">
                {{ $porcentajes['ausente'] }} %
            </span>
        </div>
    </div>
</div>

{{-- TARDANZA --}}
<div class="col-md-3">
    <div class="info-box bg-warning">
        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Tardanza</span>
            <span class="info-box-number">
                {{ $estadisticas->get('tardanza', 0) }}
            </span>
            <span class="progress-description">
                {{ $porcentajes['tardanza'] }} %
            </span>
        </div>
    </div>
</div>

{{-- EXCUSADO --}}
<div class="col-md-3">
    <div class="info-box bg-secondary">
        <span class="info-box-icon"><i class="fas fa-file-medical"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Excusado</span>
            <span class="info-box-number">
                {{ $estadisticas->get('excusado', 0) }}
            </span>
            <span class="progress-description">
                {{ $porcentajes['excusado'] }} %
            </span>
        </div>
    </div>
</div>

</div>

{{-- Tabla resumen --}}

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Resumen de asistencias</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($porcentajes as $estado => $porcentaje)
                            <tr>
                                <td>{{ ucfirst($estado) }}</td>
                                <td>{{ $estadisticas->get($estado, 0) }}</td>
                                <td>{{ $porcentaje }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
