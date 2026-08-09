{{-- resources/views/estudiante/tareas/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Mis Tareas - ' . $curso->nombre)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>{{ $curso->nombre }}</h1>
            <small class="text-muted">Tareas del curso</small>
        </div>
        <div>
            <span class="badge badge-primary">Estudiante</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs"> 
                    <div class="card-body">
                        <div class="row" id="main-content">
                            {{-- Lista de tareas --}}
                            <div class="col-lg-8" id="tasks-column">
                                <div id="tasks-list">
                                    <h4 class="mb-3">Tareas del Módulo</h4>

                                    @forelse ($tareas as $tarea)
                                        <div class="card card-primary card-outline mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5>{{ $tarea->titulo_tarea  }}</h5>
                                                        <p class="text-muted">{{ $tarea->descripcion_tarea }}</p>
                                                    </div>
                                                    <span class="badge {{ $tarea->badge_class }}">
                                                        {{ ucfirst($tarea->estado) }}
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar"></i> 
                                                        Fecha límite: {{ $tarea->fecha_entrega->format('d M Y') }}
                                                    </small>
                                                    @if($tarea->estado === 'pendiente')
                                                        <small class="text-danger font-weight-bold">
                                                            Faltan {{ $tarea->dias_restantes }} 
                                                            {{ $tarea->dias_restantes == 1 ? 'día' : 'días' }}
                                                        </small>
                                                    @elseif($tarea->estado === 'atrasado')
                                                        <small class="text-danger font-weight-bold">
                                                            Atrasado
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="progress mt-2" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $tarea->progreso }}%"></div>
                                                </div>
                                                <div class="mt-2">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('estudiante.tareas.show', $tarea->id) }}">
                                                        <i class="fas fa-eye"></i> Ver detalles y entregar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> 
                                            No hay tareas disponibles en este momento.
                                        </div>
                                    @endforelse
                                </div>
                            </div> 
                            
                            <div class="col-lg-4">
                                {{-- Recursos del curso --}}
                                @include('estudiante.partials.recursos')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop