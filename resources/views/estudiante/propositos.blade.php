@extends('adminlte::page')

@section('title', 'Propósitos - ' . $curso->nombre)

@section('content_header')
    <h1>Propósitos del Curso</h1>
@stop

@section('content')
    <div class="container-fluid">
        
        {{-- Navegación del curso --}}
        <div class="card">
            <div class="card-header">
                <h3>{{ $curso->nombre }}</h3>
                <p class="mb-0">
                    <span class="badge badge-primary">{{ $curso->codigo }}</span>
                    <span class="badge badge-info">{{ $curso->periodo }}</span>
                </p>
            </div>
        </div>

        {{-- Objetivo General --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">
                    <i class="fas fa-bullseye"></i> Objetivo General
                </h3>
            </div>
            <div class="card-body">
                @php
                    $objetivoGeneral = $curso->objetivos->where('tipo', 'general')->first();
                @endphp
                
                @if($objetivoGeneral)
                    <p class="lead">{{ $objetivoGeneral->descripcion_obj }}</p>
                @else
                    <p class="text-muted">No se ha definido un objetivo general.</p>
                @endif
            </div>
        </div>

        {{-- Objetivos Específicos --}}
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">
                    <i class="fas fa-list-ul"></i> Objetivos Específicos
                </h3>
            </div>
            <div class="card-body">
                @php
                    $objetivosEspecificos = $curso->objetivos->where('tipo', 'especifico');
                @endphp

                @if($objetivosEspecificos->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($objetivosEspecificos as $objetivo)
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                {{ $objetivo->descripcion_obj }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No se han definido objetivos específicos.</p>
                @endif
            </div>
        </div>

        {{-- Políticas del Curso --}}
        @if($curso->politicas->count() > 0)
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-gavel"></i> Políticas del Curso
                </h3>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionPoliticas">
                    @foreach($curso->politicas as $politica)
                        <div class="card mb-2">
                            <div class="card-header" id="heading{{ $loop->index }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" 
                                            type="button" 
                                            data-toggle="collapse" 
                                            data-target="#collapse{{ $loop->index }}">
                                        <i class="fas fa-chevron-down"></i>
                                        {{ $politica->titulo_politica }}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{ $loop->index }}" 
                                 class="collapse {{ $loop->first ? 'show' : '' }}" 
                                 data-parent="#accordionPoliticas">
                                <div class="card-body">
                                    {{ $politica->contenido }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
@stop