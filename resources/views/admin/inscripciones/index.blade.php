@extends('adminlte::page')

@section('title', 'Inscripciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Inscripciones</h1>
        <a href="{{ route('admin.inscripciones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Inscripción
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Filtros --}}
        {{-- <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.inscripciones.index') }}" method="GET" class="row">
                    <div class="col-md-4">
                        <input type="text" name="buscar" class="form-control" 
                               placeholder="Buscar por estudiante o curso..."
                               value="{{ request('buscar') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="estado" class="form-control">
                            <option value="">-- Todos los estados --</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="retirado" {{ request('estado') == 'retirado' ? 'selected' : '' }}>Retirado</option>
                            <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="reprobado" {{ request('estado') == 'reprobado' ? 'selected' : '' }}>Reprobado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.inscripciones.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-redo"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div> --}}

        {{-- Tabla de inscripciones --}}
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th width="60">#</th>
                            <th>Estudiante</th>
                            <th>Cédula</th>
                            <th>Curso</th>
                            <th>Período</th>
                            <th>Horas</th>
                            <th>Estado</th>
                            <th>Fecha Inscripción</th>
                            <th width="150" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                            <tr>
                                <td>{{ $inscripcion->id }}</td>
                                <td>
                                    <a href="{{ route('admin.inscripciones.cursos', $inscripcion->estudiante_id) }}">
                                        {{ $inscripcion->nombres }} {{ $inscripcion->apellidos }}
                                    </a>
                                </td>
                                <td>{{ $inscripcion->cc }}</td>
                                <td>
                                    <a href="{{ route('admin.inscripciones.estudiantes', $inscripcion->curso_id) }}">
                                        {{ $inscripcion->curso_nombre }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $inscripcion->codigo }}</small>
                                </td>
                                <td>{{ $inscripcion->periodo }}</td>
                                <td>{{ $inscripcion->horas_realizadas }}h</td>

                                <td>
                                    @switch($inscripcion->estado)
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
                                    @endswitch
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- Cambiar estado --}}
                                        <button type="button" class="btn btn-sm btn-info" 
                                                data-toggle="modal" 
                                                data-target="#modalEstado{{ $inscripcion->id }}">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        
                                        {{-- Eliminar --}}
                                        <form action="{{ route('admin.inscripciones.destroy', $inscripcion->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Eliminar esta inscripción?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Modal cambiar estado --}}
                                    @include('admin.inscripciones.partials.modal-estado', ['inscripcion' => $inscripcion])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No hay inscripciones registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($inscripciones->hasPages())
                <div class="card-footer">
                    {{ $inscripciones->links() }}
                </div>
            @endif
        </div>

    </div>
@stop