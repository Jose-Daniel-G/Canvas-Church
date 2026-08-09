@extends('adminlte::page')

@section('title', 'Nueva Calificación')

@section('content_header')
    <h1>
        <i class="fas fa-plus-circle"></i> Registrar Calificaciones
    </h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- Paso 1: Información de la Evaluación --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clipboard-check"></i> Paso 1: Información de la Evaluación
            </h3>
        </div>
        <form id="form-calificaciones">
            @csrf
            <div class="card-body">
                <div class="row"> 

                    {{-- Tipo de Evaluación --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_evaluacion">Tipo de Evaluación <span class="text-danger">*</span></label>
                            <select name="tipo_evaluacion" id="tipo_evaluacion" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                <option value="examen">Examen</option>
                                <option value="parcial">Parcial</option>
                                <option value="quiz">Quiz</option>
                                <option value="tarea">Tarea</option>
                                <option value="proyecto">Proyecto</option>
                                <option value="participacion">Participación</option>
                                <option value="asistencia">Asistencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Concepto --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="concepto">Concepto/Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="concepto" id="concepto" class="form-control" 
                                placeholder="Ej: Parcial 1, Quiz Capítulo 3, etc." required>
                            <small class="form-text text-muted">
                                Nombre descriptivo de la evaluación
                            </small>
                        </div>
                    </div>

                    {{-- Periodo --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="periodo">Periodo</label>
                            <input type="text" name="periodo" id="periodo" class="form-control" 
                                placeholder="Ej: 2026-1, Primer Corte">
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Nota Máxima --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nota_maxima">Nota Máxima <span class="text-danger">*</span></label>
                            <input type="number" name="nota_maxima" id="nota_maxima" class="form-control" 
                                value="5.0" min="1" max="100" step="0.1" required>
                        </div>
                    </div>

                    {{-- Porcentaje --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="porcentaje">Porcentaje (%) <span class="text-danger">*</span></label>
                            <input type="number" name="porcentaje" id="porcentaje" class="form-control" 
                                value="100" min="1" max="100" required>
                            <small class="form-text text-muted">
                                Peso de esta evaluación
                            </small>
                        </div>
                    </div>

                    {{-- Fecha de Calificación --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_calificacion">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_calificacion" id="fecha_calificacion" 
                                class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- Publicar --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="publicada" 
                                    name="publicada" value="1" checked>
                                <label class="custom-control-label" for="publicada">
                                    Publicar inmediatamente
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Observaciones Generales --}}
                <div class="form-group">
                    <label for="observaciones_generales">Observaciones Generales</label>
                    <textarea name="observaciones_generales" id="observaciones_generales" 
                        class="form-control" rows="2" 
                        placeholder="Comentarios sobre esta evaluación..."></textarea>
                </div>

                {{-- Relacionar con Tarea (opcional) --}}
                <div class="form-group">
                    <label for="entrega_id">Relacionar con Tarea/Entrega (Opcional)</label>
                    <select name="entrega_id" id="entrega_id" class="form-control">
                        <option value="">-- Sin relacionar --</option>
                    </select>
                    <small class="form-text text-muted">
                        Si esta calificación corresponde a una tarea específica
                    </small>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-primary" id="btn-cargar-estudiantes">
                    <i class="fas fa-arrow-right"></i> Siguiente: Ingresar Calificaciones
                </button>
                <a href="{{ route('admin.profesor.calificaciones.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    {{-- Paso 2: Tabla de Calificaciones (inicialmente oculta) --}}
    <div class="card card-success card-outline" id="card-calificaciones" style="display: none;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Paso 2: Ingresar Calificaciones
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-light" id="btn-aplicar-todos">
                    <i class="fas fa-copy"></i> Aplicar Nota a Todos
                </button>
            </div>
        </div>
        <div class="card-body">
            {{-- Resumen de la Evaluación --}}
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info-circle"></i> Resumen</h5>
                <strong>Curso:</strong> <span id="resumen-curso"></span><br>
                <strong>Evaluación:</strong> <span id="resumen-evaluacion"></span><br>
                <strong>Nota Máxima:</strong> <span id="resumen-nota-maxima"></span> | 
                <strong>Porcentaje:</strong> <span id="resumen-porcentaje"></span>%
            </div>

            {{-- Tabla de Estudiantes --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm" id="tabla-estudiantes">
                    <thead class="thead-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Estudiante</th>
                            <th width="150">Documento</th>
                            <th width="150" class="text-center">Nota <span class="text-danger">*</span></th>
                            <th>Observaciones</th>
                            <th width="100" class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-estudiantes">
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-arrow-up"></i> Seleccione un curso y presione "Siguiente"
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Estadísticas --}}
            <div class="row mt-3" id="estadisticas" style="display: none;">
                <div class="col-md-3">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Estudiantes</span>
                            <span class="info-box-number" id="stat-total">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Calificados</span>
                            <span class="info-box-number" id="stat-calificados">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pendientes</span>
                            <span class="info-box-number" id="stat-pendientes">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Promedio</span>
                            <span class="info-box-number" id="stat-promedio">0.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" class="btn btn-success" id="btn-guardar">
                <i class="fas fa-save"></i> Guardar Calificaciones
            </button>
            <button type="button" class="btn btn-secondary" id="btn-volver">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>
    </div>

</div>

{{-- Modal para aplicar nota a todos --}}
<div class="modal fade" id="modalNotaGeneral">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">
                    <i class="fas fa-copy"></i> Aplicar Nota a Todos
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Esta acción aplicará la misma nota a todos los estudiantes.</p>
                <div class="form-group">
                    <label for="nota_general">Nota a aplicar:</label>
                    <input type="number" class="form-control" id="nota_general" 
                        min="0" step="0.1" placeholder="Ej: 5.0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="btn-confirmar-nota-general">
                    Aplicar
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .nota-input {
        width: 100px;
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }
    
    .nota-input:focus {
        background-color: #fff3cd;
        border-color: #ffc107;
    }
    
    .nota-input.is-valid {
        border-color: #28a745;
        background-color: #d4edda;
    }
    
    .nota-input.is-invalid {
        border-color: #dc3545;
        background-color: #f8d7da;
    }
    
    #tabla-estudiantes tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .badge-completado {
        background-color: #28a745;
    }
    
    .badge-pendiente {
        background-color: #6c757d;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let cursoSeleccionado = null;
    let estudiantesCurso = [];
    let notaMaxima = 5.0;

    $(document).ready(function() {
        // Cargar tareas cuando se selecciona un curso
        $('#curso_id').on('change', function() {
            const cursoId = $(this).val();
            if (cursoId) {
                cargarTareasCurso(cursoId);
            }
        });

        // Botón para cargar estudiantes
        $('#btn-cargar-estudiantes').on('click', function() {
            if (!validarPaso1()) {
                return;
            }
            
            cursoSeleccionado = $('#curso_id').val();
            notaMaxima = parseFloat($('#nota_maxima').val());
            
            cargarEstudiantes();
            actualizarResumen();
            
            // Mostrar card de calificaciones
            $('#card-calificaciones').slideDown();
            
            // Scroll suave
            $('html, body').animate({
                scrollTop: $('#card-calificaciones').offset().top - 100
            }, 500);
        });

        // Volver al paso 1
        $('#btn-volver').on('click', function() {
            $('#card-calificaciones').slideUp();
        });

        // Aplicar nota a todos
        $('#btn-aplicar-todos').on('click', function() {
            $('#modalNotaGeneral').modal('show');
        });

        $('#btn-confirmar-nota-general').on('click', function() {
            const nota = parseFloat($('#nota_general').val());
            
            if (!nota || nota < 0) {
                Swal.fire('Atención', 'Ingresa una nota válida', 'warning');
                return;
            }
            
            if (nota > notaMaxima) {
                Swal.fire('Error', `La nota no puede superar ${notaMaxima}`, 'error');
                return;
            }
            
            $('.nota-input').val(nota).trigger('input');
            $('#modalNotaGeneral').modal('hide');
            $('#nota_general').val('');
            
            Swal.fire({
                icon: 'success',
                title: 'Aplicado',
                text: `Nota ${nota} aplicada a todos los estudiantes`,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });

        // Guardar calificaciones
        $('#btn-guardar').on('click', function() {
            guardarCalificaciones();
        });
    });

    // Validar paso 1
    function validarPaso1() {
        const curso = $('#curso_id').val();
        const tipo = $('#tipo_evaluacion').val();
        const concepto = $('#concepto').val();
        const notaMax = $('#nota_maxima').val();
        const porcentaje = $('#porcentaje').val();
        const fecha = $('#fecha_calificacion').val();
        
        if (!curso || !tipo || !concepto || !notaMax || !porcentaje || !fecha) {
            Swal.fire('Atención', 'Complete todos los campos obligatorios', 'warning');
            return false;
        }
        
        return true;
    }

    // Cargar tareas del curso
    function cargarTareasCurso(cursoId) {
        $.ajax({
            url: `/profesor/cursos/${cursoId}/tareas`,
            method: 'GET',
            success: function(response) {
                const select = $('#entrega_id');
                select.empty().append('<option value="">-- Sin relacionar --</option>');
                
                if (response.tareas && response.tareas.length > 0) {
                    response.tareas.forEach(tarea => {
                        select.append(`
                            <option value="${tarea.id}">
                                ${tarea.titulo_tarea} (${tarea.tipo}) - ${tarea.fecha_entrega || 'Sin fecha'}
                            </option>
                        `);
                    });
                }
            },
            error: function() {
                console.error('Error al cargar tareas');
            }
        });
    }

    // Cargar estudiantes del curso
    function cargarEstudiantes() {
        const tbody = $('#tbody-estudiantes');
        tbody.html('<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando estudiantes...</td></tr>');
        
        $.ajax({
            url: `/profesor/cursos/${cursoSeleccionado}/estudiantes`,
            method: 'GET',
            success: function(response) {
                estudiantesCurso = response.estudiantes || [];
                renderizarTablaEstudiantes();
                $('#estadisticas').slideDown();
                actualizarEstadisticas();
            },
            error: function(xhr) {
                Swal.fire('Error', 'No se pudieron cargar los estudiantes', 'error');
                tbody.html('<tr><td colspan="6" class="text-center text-danger">Error al cargar estudiantes</td></tr>');
            }
        });
    }

    // Renderizar tabla de estudiantes
    function renderizarTablaEstudiantes() {
        const tbody = $('#tbody-estudiantes');
        tbody.empty();
        
        if (estudiantesCurso.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No hay estudiantes inscritos en este curso
                    </td>
                </tr>
            `);
            return;
        }
        
        estudiantesCurso.forEach((estudiante, index) => {
            const nombreCompleto = `${estudiante.nombres || ''} ${estudiante.apellidos || ''}`.trim() || estudiante.user?.name || 'Sin nombre';
            const documento = estudiante.documento || 'N/A';
            const email = estudiante.user?.email || '';
            
            tbody.append(`
                <tr data-estudiante-id="${estudiante.id}">
                    <td class="text-center">${index + 1}</td>
                    <td>
                        <strong>${nombreCompleto}</strong>
                        ${email ? `<br><small class="text-muted">${email}</small>` : ''}
                    </td>
                    <td>${documento}</td>
                    <td class="text-center">
                        <input type="number" 
                            class="form-control nota-input" 
                            min="0" 
                            max="${notaMaxima}" 
                            step="0.1"
                            data-estudiante-id="${estudiante.id}"
                            placeholder="0.0">
                    </td>
                    <td>
                        <input type="text" 
                            class="form-control form-control-sm" 
                            placeholder="Observación..."
                            data-obs-estudiante-id="${estudiante.id}">
                    </td>
                    <td class="text-center">
                        <span class="badge badge-pendiente">Pendiente</span>
                    </td>
                </tr>
            `);
        });
        
        // Validación en tiempo real
        $('.nota-input').on('input', function() {
            validarNota($(this));
            actualizarEstadisticas();
        });
    }

    // Validar nota individual
    function validarNota($input) {
        const valor = parseFloat($input.val());
        const max = parseFloat($input.attr('max'));
        const $badge = $input.closest('tr').find('.badge');
        
        $input.removeClass('is-valid is-invalid');
        
        if (isNaN(valor) || $input.val() === '') {
            $badge.removeClass('badge-completado').addClass('badge-pendiente').text('Pendiente');
            return;
        }
        
        if (valor > max) {
            $input.val(max);
            $input.addClass('is-invalid');
            Swal.fire({
                icon: 'warning',
                title: 'Nota Inválida',
                text: `La nota no puede superar ${max}`,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        } else if (valor < 0) {
            $input.val(0);
            $input.addClass('is-invalid');
        } else {
            $input.addClass('is-valid');
            $badge.removeClass('badge-pendiente').addClass('badge-completado').text('Listo');
        }
    }

    // Actualizar resumen
    function actualizarResumen() {
        const cursoTexto = $('#curso_id option:selected').text();
        const tipoEval = $('#tipo_evaluacion option:selected').text();
        const concepto = $('#concepto').val();
        const notaMax = $('#nota_maxima').val();
        const porcentaje = $('#porcentaje').val();
        
        $('#resumen-curso').text(cursoTexto);
        $('#resumen-evaluacion').text(`${tipoEval}: ${concepto}`);
        $('#resumen-nota-maxima').text(notaMax);
        $('#resumen-porcentaje').text(porcentaje);
    }

    // Actualizar estadísticas
    function actualizarEstadisticas() {
        const total = estudiantesCurso.length;
        let calificados = 0;
        let sumaNotas = 0;
        
        $('.nota-input').each(function() {
            const valor = parseFloat($(this).val());
            if (!isNaN(valor) && valor >= 0) {
                calificados++;
                sumaNotas += valor;
            }
        });
        
        const pendientes = total - calificados;
        const promedio = calificados > 0 ? (sumaNotas / calificados).toFixed(2) : '0.0';
        
        $('#stat-total').text(total);
        $('#stat-calificados').text(calificados);
        $('#stat-pendientes').text(pendientes);
        $('#stat-promedio').text(promedio);
    }

    // Guardar calificaciones
    function guardarCalificaciones() {
        const calificaciones = [];
        let hayPendientes = false;
        
        $('.nota-input').each(function() {
            const estudianteId = $(this).data('estudiante-id');
            const nota = $(this).val();
            const observacion = $(`input[data-obs-estudiante-id="${estudianteId}"]`).val();
            
            if (!nota || nota === '') {
                hayPendientes = true;
            } else {
                calificaciones.push({
                    estudiante_id: estudianteId,
                    nota: parseFloat(nota),
                    observaciones: observacion || null
                });
            }
        });
        
        if (calificaciones.length === 0) {
            Swal.fire('Atención', 'No hay calificaciones para guardar', 'warning');
            return;
        }
        
        if (hayPendientes) {
            Swal.fire({
                title: '¿Continuar?',
                text: `Hay ${$('.badge-pendiente').length} estudiantes sin calificación. ¿Deseas guardar solo las completadas?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    enviarCalificaciones(calificaciones);
                }
            });
        } else {
            enviarCalificaciones(calificaciones);
        }
    }

    // Enviar calificaciones al servidor
    function enviarCalificaciones(calificaciones) {
        const datos = {
            _token: '{{ csrf_token() }}',
            curso_id: cursoSeleccionado,
            tipo_evaluacion: $('#tipo_evaluacion').val(),
            concepto: $('#concepto').val(),
            nota_maxima: notaMaxima,
            porcentaje: $('#porcentaje').val(),
            fecha_calificacion: $('#fecha_calificacion').val(),
            periodo: $('#periodo').val() || null,
            entrega_id: $('#entrega_id').val() || null,
            observaciones_generales: $('#observaciones_generales').val() || null,
            publicada: $('#publicada').is(':checked') ? 1 : 0,
            calificaciones: calificaciones
        };
        
        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            html: `Guardando ${calificaciones.length} calificaciones...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '{{ route("admin.profesor.calificaciones.store") }}',
            method: 'POST',
            data: datos,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    html: `
                        <p>Se guardaron <strong>${response.guardadas}</strong> calificaciones correctamente</p>
                        ${datos.publicada ? '<p class="text-success">✓ Publicadas y visibles para los estudiantes</p>' : '<p class="text-muted">En borrador (no visible para estudiantes)</p>'}
                    `,
                    confirmButtonText: 'Ir a Mis Calificaciones',
                    showCancelButton: true,
                    cancelButtonText: 'Registrar otra'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("admin.profesor.calificaciones.index") }}';
                    } else {
                        location.reload();
                    }
                });
            },
            error: function(xhr) {
                let mensaje = 'Hubo un error al guardar las calificaciones';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errores = Object.values(xhr.responseJSON.errors).flat();
                    mensaje += '<br><br><ul class="text-left">';
                    errores.forEach(error => {
                        mensaje += `<li>${error}</li>`;
                    });
                    mensaje += '</ul>';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: mensaje
                });
            }
        });
    }
</script>
@stop