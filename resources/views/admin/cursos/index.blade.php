@extends('adminlte::page')

@section('title', ucfirst(auth()->user()->getRoleNames()->first()))
@section('css')
@stop
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0"> Listado de cursos</h1>

        <a href="{{ route('admin.home') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cursos registrados</h3>
                    <div class="card-tools">
                        @can ('admin.cursos.create')
                            <a class="btn btn-secondary" data-toggle="modal" data-target="#createCursoModal">Registrar
                                <i class="bi bi-plus-circle-fill"></i>
                            </a>
                        @endcan

                    </div>
                </div>

                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success"><strong>{{ session('info') }}</strong></div>
                    @endif
                    <table id="cursos" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nro</th>
                                <th>Curso</th>
                                <th>Horas</th>
                                <th>Ver</th>
                                @if (!Auth::user()->estudiante)
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            @foreach ($cursos as $curso)
                                <tr>
                                    <td scope="row">{{ $contador++ }}</td>
                                    <td scope="row">{{ $curso->nombre }}</td>
                                    <td scope="row">{{ $curso->horas_requeridas }}</td>
                                    <td scope="row">
                                        {{-- Botón VER --}}
                                        <a href="{{ route('admin.cursos.show', $curso) }}" class="btn btn-sm btn-info"
                                            title="Ver curso">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>

                                    @if (!Auth::user()->estudiante)
                                        <td scope="row">
                                            <form id="disable-form-{{ $curso->id }}"
                                                action="{{ route('admin.cursos.toggleStatus', $curso->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH') <!-- Laravel permite cambios parciales con PATCH -->
                                                <button type="submit"
                                                    class="btn {{ $curso->estado ? 'btn-success' : 'btn-danger' }}  btn-sm">
                                                    {!! $curso->estado ? '<i class="fa-solid fa-square-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>' !!}
                                                </button>
                                            </form>
                                        </td>
                                        <td scope="row">
                                            <a href="{{ route('admin.cursos.edit', $curso->id) }}"
                                                class="btn btn-warning btn-sm mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form id="delete-form-{{ $curso->id }}"
                                                action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $curso->id }}"
                                                    data-text="¿Estás seguro de que deseas eliminar este curso?">
                                                    <i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('admin.cursos.create')
                    {{-- @include('admin.cursos.show') --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')


    <script>
        new DataTable('#cursos', {
            responsive: true,
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip', // Añade el contenedor de botones
            buttons: [{
                    extend: 'copyHtml5',
                    text: '<i class="bi bi-clipboard-check"></i> Copiar',
                    className: 'btn btn-sm btn-success'
                }, // Added btn-sm for better consistency
                {
                    extend: 'csvHtml5',
                    text: '<i class="bi bi-filetype-csv"></i> CSV',
                    className: 'btn btn-sm btn-warning'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-filetype-pdf"></i> PDF',
                    className: 'btn btn-sm btn-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-sm btn-dark'
                },
                {
                    extend: 'colvis'
                }
            ],
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ cursos",
                "infoEmpty": "Mostrando 0 a 0 de 0 cursos",
                "infoFiltered": "(filtrado de _MAX_ cursos totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ cursos",
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
@stop
