@extends('adminlte::page')

@section('title', 'Mi Curso - ' . $curso->nombre)

@section('content_header')
    <h1>{{ $curso->nombre }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        
        {{-- Información del curso --}}
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4>{{ $curso->codigo }}</h4>
                        <p>Código del curso</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hashtag"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>{{ $curso->periodo }}</h4>
                        <p>Período</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        @php
                            $tareasPendientes = $curso->tareas->filter(function($tarea) use ($estudiante) {
                                return !$tarea->entregas->where('estudiante_id', $estudiante->id)->count();
                            })->count();
                        @endphp
                        <h4>{{ $tareasPendientes }}</h4>
                        <p>Tareas Pendientes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h4>{{ $curso->profesores->count() }}</h4>
                        <p>{{ $curso->profesores->count() == 1 ? 'Profesor' : 'Profesores' }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Descripción del curso --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Descripción del Curso
                </h3>
            </div>
            <div class="card-body">
                <p>{{ $curso->descripcion ?? 'Sin descripción disponible.' }}</p>
            </div>
        </div>

        {{-- Profesores del curso --}}
        @if($curso->profesores->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i> Profesores
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($curso->profesores as $profesor)
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon">
                                    <i class="fas fa-user-tie"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        {{ $profesor->nombres }} {{ $profesor->apellidos }}
                                    </span>
                                    <span class="info-box-number">
                                        <small>{{ $profesor->telefono ?? 'Sin teléfono' }}</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Próximas tareas --}}
        @if($curso->tareas->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i> Próximas Entregas
                </h3>
                <div class="card-tools">
                    <a href="{{ route('estudiante.tareas.index') }}" class="btn btn-sm btn-primary">
                        Ver todas las tareas
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Fecha Límite</th>
                            <th>Puntaje</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($curso->tareas->take(5) as $tarea)
                            @php
                                $entregado = $tarea->entregas->where('estudiante_id', $estudiante->id)->first();
                            @endphp
                            <tr>
                                <td>{{ $tarea->titulo }}</td>
                                <td>
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y') }}
                                </td>
                                <td>{{ $tarea->puntaje }}</td>
                                <td>
                                    @if($entregado)
                                        @if($entregado->calificacion)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> Calificada: {{ $entregado->calificacion }}
                                            </span>
                                        @else
                                            <span class="badge badge-info">
                                                <i class="fas fa-clock"></i> Entregada
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation"></i> Pendiente
                                        </span>
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