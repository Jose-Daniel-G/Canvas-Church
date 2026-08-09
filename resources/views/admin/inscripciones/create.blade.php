@extends('adminlte::page')

@section('title', 'Nueva Inscripción')

@section('content_header')
<h1>Inscribir Estudiante a Curso</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Inscripción Individual --}}
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i> Inscripción Individual</h3>
                </div>
                <form action="{{ route('admin.inscripciones.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Estudiante <span class="text-danger">*</span></label>
                            <select name="estudiante_id" class="form-control select2" required>
                                <option value="">-- Seleccione un estudiante --</option>
                                @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Curso <span class="text-danger">*</span></label>
                            <select name="curso_id" class="form-control select2 select-curso" required>
                                <option value="">-- Seleccione un curso --</option>
                                @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nombre }} ({{ $curso->codigo }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Profesor <span class="text-danger">*</span></label>
                            <select name="profesor_id" class="form-control select2 select-profesor" required disabled>
                                <option value="">-- Seleccione primero un curso --</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        @can('admin.acciones.insMasiva')
        {{-- Inscripción Masiva --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Inscripción Masiva
                    </h3>
                </div>
                <form action="{{ route('admin.inscripciones.store-multiple') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Seleccionar Curso --}}
                        <div class="form-group">
                            <label for="curso_id_multiple">Curso <span class="text-danger">*</span></label>
                            <select name="curso_id"
                                id="curso_id_multiple"
                                class="form-control select2"
                                required>
                                <option value="">-- Seleccione un curso --</option>
                                @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}">
                                    {{ $curso->codigo }} - {{ $curso->nombre }} ({{ $curso->periodo }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Seleccionar Estudiantes (múltiple) --}}
                        <div class="form-group">
                            <label for="estudiantes">Estudiantes <span class="text-danger">*</span></label>
                            <select name="estudiantes[]"
                                id="estudiantes"
                                class="form-control select2"
                                multiple
                                required
                                style="width: 100%;">
                                @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}">
                                    {{ $estudiante->nombres }} {{ $estudiante->apellidos }} - {{ $estudiante->cc }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Mantén presionado Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples estudiantes</small>
                        </div>
                        <div class="form-group">
                            <label>Profesor <span class="text-danger">*</span></label>
                            <select name="profesor_id" class="form-control select2 select-profesor" required disabled>
                                <option value="">-- Seleccione primero un curso --</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-users-cog"></i> Inscribir Seleccionados
                        </button>
                        <a href="{{ route('admin.inscripciones.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        @endcan
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inicialización de Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // 1. Detectar cambio en el curso (usamos una clase común)
    // Asegúrate de que los select de curso tengan la clase 'select-curso'
    $(document).on('change', '.select-curso', function() {
        let cursoId = $(this).val();
        let $card = $(this).closest('.card-body');
        let $selectProfesor = $card.find('.select-profesor');

        if (!cursoId) {
            $selectProfesor.prop('disabled', true).html('<option value="">-- Seleccione curso primero --</option>');
            return;
        }

        // Estado de carga
        $selectProfesor.prop('disabled', true).html('<option>Cargando...</option>');

        // Petición AJAX
        $.get("{{ route('admin.inscripciones.get_profesores', '') }}/" + cursoId, function(data) {
            $selectProfesor.empty().append('<option value="">-- Seleccione Profesor --</option>');

            if (data && data.length > 0) {
                data.forEach(prof => {
                    $selectProfesor.append(`<option value="${prof.id}">${prof.nombres} ${prof.apellidos}</option>`);
                });
                $selectProfesor.prop('disabled', false);
            } else {
                $selectProfesor.append('<option value="">No hay profesores con clases en este curso</option>');
            }

            // IMPORTANTE: Refrescar Select2 para que muestre los nuevos <option>
            $selectProfesor.trigger('change'); 
        }).fail(function() {
            $selectProfesor.html('<option value="">Error al cargar</option>');
        });
    });

    // 2. Habilitar campos antes de enviar
    $('form').on('submit', function(e) {
        let $profesor = $(this).find('.select-profesor');
        
        if ($profesor.is(':disabled')) {
            $profesor.prop('disabled', false);
        }

        if (!$profesor.val() && $(this).find('.select-curso').val()) {
            e.preventDefault();
            alert('Debe seleccionar un profesor para continuar.');
        }
    });
});
</script>

@stop