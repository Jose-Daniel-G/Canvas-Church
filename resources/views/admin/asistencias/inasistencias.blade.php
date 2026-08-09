@extends('adminlte::page')

@section('title', ucfirst(auth()->user()->getRoleNames()->first()))

@section('content_header')
    <h2> Estudiantes con Penalidades</h2>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Historial</h3>
                    <div class="card-tools">
                        {{-- <a href="{{ route('admin.') }}" class="btn btn-primary">Registrar <i class="fa-solid fa-plus"></i> --}}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="inacistencia" class="table table-striped table-bordered table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Nombre del Estudiante</th>
                                <th>Curso</th>
                                <th>Fecha</th>
                                <th>Hora Inicio y Fin</th>
                                <th>Asistio</th>
                                <th>Horas Penalizadas</th>
                                <th>Penalidad Total</th>
                                <th>liquidado</th>
                                <th>fecha de pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->nombre . ' ' . $estudiante->apellido }}</td>
                                    <td>{{ $estudiante->nombre_evento }}</td>
                                    <td>{{ $estudiante->date }}</td>
                                    <td>{{ $estudiante->start . ' ' . $estudiante->end }}</td>
                                    <td>
                                        <i class="{{ $estudiante->asistio ? 'text-success bi bi-check-circle-fill' : 'text-danger bi bi-x-circle-fill' }}"></i>
                                    </td>
                                    <td>{{ $estudiante->asistio ? '' : $estudiante->cant_horas . ' horas' }}</td>
                                    <td>{{ $estudiante->asistio ? '' : $estudiante->penalidad }}</td>
                                    <td>
                                        @if (!$estudiante->asistio)
                                            <i class="{{ $estudiante->liquidado ? 'text-success bi bi-check-circle-fill' : 'text-danger bi bi-x-circle-fill' }}"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$estudiante->asistio)
                                            {{ $estudiante->fecha_pago_multa }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$estudiante->liquidado)
                                            <form action="{{ route('admin.asistencia.habilitar', $estudiante->id) }}"
                                                method="POST">
                                                @csrf

                                                <button type="submit" class="form-control btn btn-success">Habilitar
                                                    Estudiante</button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script> 
            new DataTable('#inacistencia', {
                responsive: true,
                autoWidth: false,scrollX:true,
                scrollX: true,
            });
    </script>
@stop

