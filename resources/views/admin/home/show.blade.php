@extends('adminlte::page')

@section('title', 'Clases')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
@section('content_header')
    <h1>Listado de clases</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Clases registradas</h3>
                    @can('admin.clases.create')
                        <div class="card-tools">
                            <a class="btn btn-secondary" data-toggle="modal" data-target="#createClaseModal">Nueva clase
                                <i class="bi bi-plus-circle-fill"></i>
                            </a>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    @if (session('info') && session('icon'))
                        <div class="alert alert-success"><strong>{{ session('info') }}</strong></div>
                    @endif
                    <table id="reservas" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nro</th>
                                <th>Profesor</th>
                                <th>Estudiante</th>
                                <th>Curso</th>
                                <th>Fecha de reserva</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                                {{-- <th>Fecha y hora de registro</th> --}}
                                @if (auth()->user()->can('admin.clases.edit') || auth()->user()->can('admin.clases.destroy'))
                                    <th>Acciones</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            @foreach ($clases as $clase)
                                <tr>
                                    <td scope="row">{{ $contador++ }}</td>
                                    <td scope="row">{{ $clase->profesor ? $clase->profesor->nombres . ' ' . $clase->profesor->apellidos : 'Sin asignar' }}</td>
                                    <td scope="row">{{ $clase->estudiantes->map(fn ($e) => $e->nombres . ' ' . $e->apellidos)->implode(', ') ?: 'Sin estudiantes' }}</td>
                                    <td scope="row" class="text-center">{{ $clase->curso->nombre ?? 'N/A' }}</td>
                                    <td scope="row" class="text-center">{{ $clase->fecha_hora_inicio->format('d M, Y') }}</td>
                                    <td scope="row" class="text-center">{{ $clase->fecha_hora_inicio->format('H:i') }}</td>
                                    <td scope="row" class="text-center">{{ $clase->fecha_hora_fin->format('H:i') }}</td>
                                    {{-- <td scope="row" class="text-center">{{ $clase->created_at }}</td> --}}
                                    {{-- <td scope="row" class="text-center">{{ $clase->id }}</td> --}}


                                    @if (auth()->user()->can('admin.clases.edit') || auth()->user()->can('admin.clases.destroy'))
                                        <td scope="row">
                                            <div class="btn-group" role="group" aria-label="basic example">
                                                @can('admin.clases.edit')
                                                    {{-- button EDIT --}}
                                                    <a href="#" class="btn btn-warning btn-sm mr-1"
                                                        data-id="{{ $clase->id }}" data-toggle="modal" data-target="#editClaseModal"
                                                        title="Editar"> <i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('admin.clases.destroy')
                                                    <div class="btn-group" role="group" aria-label="basic example">
                                                        <form id="delete-form-{{ $clase->id }}"
                                                            action="{{ route('admin.clases.destroy', $clase->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-delete"
                                                        data-id="{{ $clase->id }}"
                                                        data-text="¿Estás seguro de eliminar esta  reserva?">
                                                        <i class="fas fa-trash"></i>
                                            </form>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>

                    @include('admin.clases.create')
                    @include('admin.clases.edit')
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script>
        new DataTable('#reservas', {
            responsive: true,
            autoWidth: false, //no le vi la funcionalidad
            dom: 'Bfrtip', // Añade el contenedor de botones
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{extend: 'copyHtml5',text: '<i class="bi bi-clipboard-check"></i> Copiar'}, // Added btn-sm for better consistency
                          {extend: 'csvHtml5',text: '<i class="bi bi-filetype-csv"></i> CSV'},
                          {extend: 'excelHtml5',text: '<i class="bi bi-file-earmark-excel"></i> Excel'},
                          {extend: 'pdfHtml5',text: '<i class="bi bi-filetype-pdf"></i> PDF'},
                          {extend: 'print',text: '<i class="bi bi-printer"></i> Imprimir' },
                          {extend: 'colvis'}],
            }, ],
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ reservas",
                "infoEmpty": "Mostrando 0 a 0 de 0 reservas",
                "infoFiltered": "(filtrado de _MAX_ reservas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ reservas",
                "loadingRecords": "Cargando...",
                "processing": "",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "orderable": "Ordenar por esta columna",
                    "orderableReverse": "Invertir el orden de esta columna"
                }
            }

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2-estudiantes').select2({
            placeholder: 'Seleccione los estudiantes de la clase',
            width: '100%',
        });

        $('#editClaseModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);

            var url = "{{ route('admin.clases.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    var formAction = "{{ route('admin.clases.update', ':id') }}".replace(':id', response.clase.id);
                    modal.find('#editClaseForm').attr('action', formAction);

                    modal.find('#edit-titulo').val(response.clase.titulo);
                    modal.find('#edit-curso_id').val(response.clase.curso_id);
                    modal.find('#edit-profesor_id').val(response.clase.profesor_id);
                    modal.find('#edit-fecha_hora_inicio').val(response.clase.fecha_hora_inicio.replace(' ', 'T').slice(0, 16));
                    modal.find('#edit-fecha_hora_fin').val(response.clase.fecha_hora_fin.replace(' ', 'T').slice(0, 16));
                    modal.find('#edit-estado').val(response.clase.estado);
                    modal.find('#edit-color').val(response.clase.color || '#3788d8');
                    modal.find('#edit-aula').val(response.clase.aula);
                    modal.find('#edit-modalidad').val(response.clase.modalidad);
                    modal.find('#edit-link_virtual').val(response.clase.link_virtual);

                    modal.find('#edit-estudiantes').val(response.estudiantesSeleccionados).trigger('change');
                },
                error: function (xhr) {
                    console.error('Error al cargar los datos de la clase:', xhr);
                    alert('No se pudieron cargar los datos de la clase. Por favor, intente de nuevo.');
                }
            });
        });

        $('#editClaseForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function () {
                    $('#editClaseModal').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('Error al actualizar la clase');
                }
            });
        });
    </script>
@stop
