@extends('adminlte::page')

@section('title', 'Cursos del Estudiante')

@section('content_header')
    <h1>Cursos de {{ $estudiante->nombres }} {{ $estudiante->apellidos }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Inscripciones</h3>
    </div>
    <div class="card-body">
        @if($cursos->isEmpty())
            <div class="alert alert-warning">
                Este estudiante no está inscrito en ningún curso.
            </div>
        @else
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Código</th>
                        <th>Periodo</th>
                        <th>Fecha de inscripción</th>
                        <th>Horas realizadas</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $index => $curso)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $curso->nombre }}</td>
                            <td>{{ $curso->codigo ?? '-' }}</td>
                            <td>{{ $curso->periodo ?? '-' }}</td>
                            <td>
                                {{ $curso->pivot->fecha_inscripcion 
                                    ? \Carbon\Carbon::parse($curso->pivot->fecha_inscripcion)->format('d/m/Y') 
                                    : '-' }}
                            </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $porcentaje = $curso->horas_requeridas > 0 
                                                ? round(($curso->pivot->horas_realizadas / $curso->horas_requeridas) * 100, 2)
                                                : 0;
                                            $clase = $porcentaje >= 100 ? 'bg-success' : ($porcentaje >= 50 ? 'bg-info' : 'bg-warning');
                                        @endphp
                                        <div class="progress-bar {{ $clase }}" role="progressbar" 
                                             style="width: {{ min($porcentaje, 100) }}%">
                                            {{ $curso->pivot->horas_realizadas ?? 0 }}h / {{ $curso->horas_requeridas }}h
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $porcentaje }}%</small>
                                </td>
<td class="text-center">
                                    @if(isset($curso->pivot->estado))
                                        @switch($curso->pivot->estado)
                                            @case('activo')
                                                <span class="badge badge-primary">Activo</span>
                                                @break
                                            @case('retirado')
                                                <span class="badge badge-warning">Retirado</span>
                                                @break
                                            @case('aprobado')
                                                <span class="badge badge-success">Aprobado</span>
                                                @break
                                            @case('reprobado')
                                                <span class="badge badge-danger">Reprobado</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($curso->pivot->estado) }}</span>
                                        @endswitch
                                    @else
                                        <span class="badge badge-secondary">Activo</span>
                                    @endif
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.inscripciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Inscripciones
        </a>
        <a href="{{ route('admin.estudiantes.show', $estudiante->id) }}" class="btn btn-info">
            <i class="fas fa-user"></i> Ver Perfil del Estudiante
        </a>
    </div>
</div>
@stop