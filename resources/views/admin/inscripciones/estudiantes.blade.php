@extends('adminlte::page')

@section('title', 'Estudiantes del Curso')

@section('content_header')
    <h1>Estudiantes de {{ $curso->nombre }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Inscritos</h3>
        <div class="card-tools">
            <span class="badge badge-primary">{{ $estudiantes->count() }} estudiantes</span>
        </div>
    </div>
    <div class="card-body">
        @if($estudiantes->isEmpty())
            <div class="alert alert-warning">
                No hay estudiantes inscritos en este curso.
            </div>
        @else
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Cédula</th>
                        <th>Fecha de inscripción</th>
                        <th>Horas realizadas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estudiantes as $key => $estudiante)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</td>
                            <td>{{ $estudiante->cc }}</td>
                            <td>
                                {{ $estudiante->fecha_inscripcion 
                                    ? \Carbon\Carbon::parse($estudiante->fecha_inscripcion)->format('d/m/Y') 
                                    : '-' }}
                            </td>
                            <td>{{ $estudiante->horas_realizadas ?? 0 }}h</td>
                            <td>
                                <span class="badge badge-success">Activo</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.estudiantes.show', $estudiante->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.inscripciones.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>
</div>
@stop