@extends('adminlte::page')

@section('title', 'Editar Tarea')

@section('content_header')
    <h1><i class="fas fa-edit"></i> Editar Tarea: {{ $tarea->titulo_tarea }}</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- Importante: El método debe ser PUT o PATCH para edición --}}
    <form action="{{ route('admin.profesor.tareas.update', $tarea->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            {{-- Columna izquierda --}}
            <div class="col-md-8">
                
                {{-- Información Básica --}}
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Información Básica</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="curso_id">Curso <span class="text-danger">*</span></label>
                            <select name="curso_id" id="curso_id" class="form-control @error('curso_id') is-invalid @enderror" required>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ old('curso_id', $tarea->curso_id) == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->codigo }} - {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo">Tipo de Actividad <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                                @php $tipos = ['tarea', 'quiz', 'examen', 'proyecto', 'foro']; @endphp
                                @foreach($tipos as $t)
                                    <option value="{{ $t }}" {{ old('tipo', $tarea->tipo) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="titulo_tarea">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo_tarea" id="titulo_tarea" class="form-control @error('titulo_tarea') is-invalid @enderror" 
                                   value="{{ old('titulo_tarea', $tarea->titulo_tarea) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion_tarea">Descripción <span class="text-danger">*</span></label>
                            <textarea name="descripcion_tarea" id="descripcion_tarea" class="form-control @error('descripcion_tarea') is-invalid @enderror" rows="5" required>{{ old('descripcion_tarea', $tarea->descripcion_tarea) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Recursos Actuales y Nuevos --}}
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-paperclip"></i> Recursos y Documentos</h3>
                    </div>
                    <div class="card-body">
                        @if($tarea->documentos->count() > 0)
                            <h6>Documentos actuales:</h6>
                            <ul class="list-group mb-3">
                                @foreach($tarea->documentos as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-file-alt"></i> {{ $doc->titulo }}</span>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ asset('storage/'.$doc->archivo) }}" target="_blank" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            {{-- Botón para eliminar el documento (requiere lógica en controlador) --}}
                                            <button type="button" class="btn btn-danger" onclick="eliminarArchivo({{ $doc->id }})"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="form-group">
                            <label for="documentos">Agregar nuevos archivos</label>
                            <div class="custom-file">
                                <input type="file" name="documentos[]" id="documentos" class="custom-file-input" multiple>
                                <label class="custom-file-label" for="documentos">Seleccionar archivos...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna derecha --}}
            <div class="col-md-4">
                {{-- Fechas --}}
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Fechas</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fecha_apertura">Apertura</label>
                            <input type="datetime-local" name="fecha_apertura" id="fecha_apertura" class="form-control" 
                                   value="{{ old('fecha_apertura', $tarea->fecha_apertura ? date('Y-m-d\TH:i', strtotime($tarea->fecha_apertura)) : '') }}">
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega">Entrega <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="fecha_entrega" id="fecha_entrega" class="form-control" 
                                   value="{{ old('fecha_entrega', date('Y-m-d\TH:i', strtotime($tarea->fecha_entrega))) }}" required>
                        </div>
                    </div>
                </div>

                {{-- Calificación --}}
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-star"></i> Calificación</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="puntaje">Puntaje Máximo</label>
                            <input type="number" name="puntaje" id="puntaje" class="form-control" value="{{ old('puntaje', $tarea->puntaje) }}" tabindex="1">
                        </div> 

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="permite_entregas_tardias" name="permite_entregas_tardias" 
                                   {{ old('permite_entregas_tardias', $tarea->permite_entregas_tardias) ? 'checked' : '' }} onchange="togglePenalizacion()">
                            <label class="custom-control-label" for="permite_entregas_tardias">Permitir entregas tardías</label>
                        </div>

                        <div id="div_penalizacion" class="form-group" style="display: none;">
                            <label for="penalizacion_tardia">Penalización</label>
                            <input type="number" name="penalizacion_tardia" id="penalizacion_tardia" class="form-control" value="{{ old('penalizacion_tardia', $tarea->penalizacion_tardia) }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="{{ route('admin.profesor.tareas.index') }}" class="btn btn-secondary btn-block">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Formulario oculto para eliminar documentos --}}
<form id="form-eliminar-doc" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@stop

@section('js')
<script>
    function togglePenalizacion() {
        const checkbox = document.getElementById('permite_entregas_tardias');
        const div = document.getElementById('div_penalizacion');
        div.style.display = checkbox.checked ? 'block' : 'none';
    }

    function eliminarArchivo(docId) {
        if(confirm('¿Estás seguro de eliminar este documento?')) {
            const form = document.getElementById('form-eliminar-doc');
            form.action = `/profesor/tareas/documentos/${docId}`;
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        togglePenalizacion();
    });
</script>
@stop