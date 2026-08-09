@extends('adminlte::page')

@section('title', ucfirst(auth()->user()->getRoleNames()->first()))
@section('css')
@stop
@section('content_header')
    <h1>Panel principal</h1>
@stop

@section('content') 
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">    
                <div class="card-header">
                    <h3 class="card-title">Usuarios registrados</h3>
                    <div class="card-tools">
                        <a class="btn btn-secondary" data-toggle="modal" data-target="#createEstudianteModal">Registrar
                            <i class="bi bi-plus-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($info = Session::get('info'))
                        <div class="alert alert-success"><strong>{{ session('info') }}</strong></div>
                    @endif
                    <table id="estudiantes" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nro</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>cc</th>
                                <th>email</th>
                                <th>Direccion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    @include('admin.estudiantes.create')
                    @include('admin.estudiantes.edit')
                    {{-- @include('admin.estudiantes.show') --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#estudiantes').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,scrollX: true,
                autoWidth: false,
                ajax: '{{ route("admin.estudiantes.index") }}',
                columns: [{ data: 'id', name: 'id' },
                        { data: 'nombres', name: 'nombres' },
                        { data: 'apellidos', name: 'apellidos' },
                        { data: 'cc', name: 'cc' },
                        { data: 'user.email', name: 'user.email' },
                        { data: 'direccion', name: 'direccion' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }], 
                scrollX: true,
                autoWidth: false,
                dom: 'Bfrtip', // This correctly enables the Buttons extension
                buttons: [{extend: 'copyHtml5',text: '<i class="bi bi-clipboard-check"></i> Copiar',className: 'btn btn-sm btn-success'}, // Added btn-sm for better consistency
                          {extend: 'csvHtml5',text: '<i class="bi bi-filetype-csv"></i> CSV',className: 'btn btn-sm btn-warning'},
                          {extend: 'excelHtml5',text: '<i class="bi bi-file-earmark-excel"></i> Excel',className: 'btn btn-sm btn-secondary'},
                          {extend: 'pdfHtml5',text: '<i class="bi bi-filetype-pdf"></i> PDF',className: 'btn btn-sm btn-danger'},
                          {extend: 'print',text: '<i class="bi bi-printer"></i> Imprimir',className: 'btn btn-sm btn-dark' },
                          {extend: 'colvis'}
                ],
                language: {
                    decimal: "",
                    emptyTable: "No hay datos disponibles en la tabla",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ estudiantes",
                    infoEmpty: "Mostrando 0 a 0 de 0 estudiantes",
                    infoFiltered: "(filtrado de _MAX_ estudiantes totales)",
                    lengthMenu: "Mostrar _MENU_ estudiantes",
                    loadingRecords: "Cargando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron registros coincidentes",
                    paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior"}
                }
            });
        });

        $('#editEstudianteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);

            var url = "{{ route('admin.estudiantes.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // Rellenar los campos del estudiante
                    var formAction = "{{ route('admin.estudiantes.update', ':id') }}".replace(':id',response.estudiante.id);
                    modal.find('#editEstudianteForm').attr('action', formAction);

                    modal.find('#edit-nombres').val(response.estudiante.nombres);
                    modal.find('#edit-apellidos').val(response.estudiante.apellidos);
                    modal.find('#edit-cc').val(response.estudiante.cc);
                    modal.find('#edit-telefono').val(response.estudiante.telefono);
                    modal.find('#edit-direccion').val(response.estudiante.direccion);
                    modal.find('#edit-contacto_emergencia').val(response.estudiante.contacto_emergencia);
                    modal.find('#edit-email').val(response.estudiante.user.email);
                    modal.find('#edit-observaciones').val(response.estudiante.observaciones);

                    // Seleccionar la opción de género
                    modal.find('#edit-genero').val(response.estudiante.genero);

                    // Rellenar y seleccionar los checkboxes de los cursos
                    var cursosContainer = modal.find('#cursos-checkboxes');
                    cursosContainer.empty(); // Limpiar checkboxes anteriores

                    // Iterar sobre todos los cursos y crear los checkboxes
                    response.cursos.forEach(function(curso) {
                        var isChecked = response.cursosSeleccionados.includes(curso.id) ?
                            'checked' : '';
                        var checkboxHtml = `
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input type="checkbox" name="cursos[]" value="${curso.id}"
                                        class="form-check-input" id="edit-curso-${curso.id}" ${isChecked}>
                                    <label class="form-check-label" for="edit-curso-${curso.id}">
                                        ${curso.nombre}
                                    </label>
                                </div>
                            </div>`;
                        cursosContainer.append(checkboxHtml);
                    });
                },
                error: function(xhr) {
                    console.error('Error al cargar los datos del estudiante:', xhr);
                    alert('No se pudieron cargar los datos del estudiante. Por favor, intente de nuevo.');
                }
            });
        });
        $('#editEstudianteForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize() + '&_method=PUT'; // <- importante
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#editEstudianteModal').modal('hide');
                    Swal.fire({text: "Estudiante actualizado correctamente",icon: "success"});
                    $('#estudiantes').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error al actualizar estudiante');
                }
            });
        });
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();

    let form = $(this).closest('form');

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Este registro se eliminará definitivamente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

    </script>
@stop
