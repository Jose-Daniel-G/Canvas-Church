@extends('adminlte::page')

@section('title', ucfirst(auth()->user()->getRoleNames()->first())){{-- @section('plugins.Sweetalert2', true) --}}
@section('css')
    @vite('resources/css/items.css')
@stop

@section('content_header'){{-- <h1><b>Bienvenido:</b> {{ Auth::user()->email }} / <b>Rol:</b> {{ Auth::user()->roles->pluck('name')->first() }}</h1> --}}
@stop
@section('content')
    @if ($esProfesor)
        <div class="row pt-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $misCursos->count() }}</h3>
                        <p>Mis cursos</p>
                    </div>
                    <div class="icon"><i class="fas fa-book"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalMisEstudiantes }}</h3>
                        <p>Estudiantes a cargo</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $entregasPendientes }}</h3>
                        <p>Entregas por calificar</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-signature"></i></div>
                    <a href="{{ route('admin.profesor.tareas.index') }}" class="small-box-footer">Ver tareas <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $proximasClases->count() }}</h3>
                        <p>Próximas clases</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mis próximas clases</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proximasClases as $clase)
                                    <tr>
                                        <td>{{ $clase->curso->nombre ?? 'N/A' }}</td>
                                        <td>{{ $clase->fecha_hora_inicio->format('d M, Y') }}</td>
                                        <td>{{ $clase->fecha_hora_inicio->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No tiene clases próximas
                                            programadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Mis cursos</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($misCursos as $curso)
                                    <tr>
                                        <td>{{ $curso->nombre }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted">Aún no tiene cursos asignados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row pt-3">
        {{-- Configuracion --}}
        @can('admin.config.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_configuraciones }}</h3>
                        <p>Configuracion</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <a href="{{ route('admin.config.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Programador --}}
        @can('admin.secretarias.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_secretarias }}</h3>
                        <p>Programador</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <a href="{{ route('admin.secretarias.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Estudiantes --}}
        @can('admin.estudiantes.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_estudiantes }}</h3>
                        <p>Estudiantes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users mr-2"></i>
                    </div>
                    <a href="{{ route('admin.estudiantes.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Cursos --}}
        @can('admin.cursos.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $total_cursos }}</h3>
                        <p>Cursos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="{{ route('admin.cursos.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Profesores --}}
        @can('admin.estudiantes.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $total_profesores }}</h3>
                        <p>Profesores</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <a href="{{ route('admin.profesores.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Horarios --}}
        @can('admin.horarios.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $total_horarios }}</h3>

                        <p>Horarios</p>
                        {{-- <p>{{ __('actions.schedules') }}</p> --}}
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <a href="{{ route('admin.horarios.index') }}" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endcan
        {{-- Reservas --}}
        @can('admin.reservas.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $total_agendas }}</h3>

                        <p>Reservas</p>
                    </div>
                    <div class="icon">
                        <i class="ion fas bi bi-calendar2-week"></i>
                    </div>
                    <a href="" class="small-box-footer"> <i class="fas fa-calendar-alt"></i></a>
                </div>
            </div>
        @endcan

        {{-- Completados --}}
        {{-- @can('admin.cursos.completados') --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    {{-- @if (Auth::user()->estudiante) --}}
                        <h4>Progreso</h4>
                        <h5 class="mb-2">(Cursos)</h5>
                        <br> 
                    {{-- @endif --}}

                </div>
                <div class="icon"> <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i
                        class="fas fa-arrow-circle-right"></i></a>
                {{-- <a href="{{ route('admin.cursos.completados') }}" class="small-box-footer">Mas info <i
                        class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        {{-- @endcan --}}
        @if (Auth::user()->hasRole('pruebas'))
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <!-- ROMBO -->
                    <div class="shape-item shape-sm">
                        <div class="diamond badge-shape">
                            <span class="diamond-text"><i class="far fa-star"></i></span>
                        </div>
                    </div>
                    <div class="info-box-content"> Insign Rombo</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <div class="shape-item shape-sm">
                        <div class="octagon badge-shape">
                            <span class="octagon-text">Oct</span>
                        </div>
                    </div>
                    <div class="shape-label">Octagono</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <div class="shape-item shape-sm">
                        <div class="shield badge-shape">
                            <span class="shield-text">Escudo</span>
                        </div>
                    </div>
                    <div class="shape-label">Escudo</div>
                </div>
            </div>
            {{-- <div class="col-lg-2 col-2"> 
                <div class="shape-item shape-sm">
                    <div class="pentagon">
                        <span class="pentagon-text">PREMIUM</span>
                    </div>
                    <div class="shape-label">Pentágono</div>
                </div>
            </div> --}}
        @endif


    </div>
    {{-- <div class="card card-primary card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                @can('show_datos_cursos')
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                            href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                            aria-selected="false">Calendario de reserva</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="false">Horario de  profesores</a>
                    </li>
                @endcan

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel"
                    aria-labelledby="custom-tabs-three-home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Calendario de atencion de profesores </h3>
                        </div>
                        <div class="col-md d-flex justify-content-end">
                            <label for="curso_id">Cursos </label><b class="text-danger">*</b>
                        </div>
                        <div class="col-md-4">
                            <select name="curso_id" id="profesor_select" class="form-control">
                                <option value="" selected disabled>Seleccione una opción</option>
                                @foreach ($profesorSelect as $curso)
                                    <option value="{{ $curso->id }}">
                                        {{ $curso->cursos . ' - ' . $curso->nombres }} </option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->admin || Auth::user()->profesor)
                            <div class="col-md">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#claseModal">
                                    Agendar
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div id="curso_info"></div>
                        </div>

                    </div>
                </div>
                @can('show_datos_cursos')
                    <div class="tab-pane fade show" id="custom-tabs-three-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-three-profile-tab">
                        <div class="row">

                            <div class="col-md-12">
                                <!-- Button trigger modal -->
                                @if (!Auth::user()->estudiante)
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#claseModal"> Agendar Clase</button>
                                @endif
                                @if (Auth::user()->superAdmin)
                                <a href="{{ route('admin.home.show') }}" class="btn btn-success">
                                    <i class="bi bi-calendar-check"></i>Ver las reservas
                                </a>
                                @endif
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="profesor_info"></div>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                @endcan
               
            </div>
        </div>
    </div> --}}
    {{-- PROFESORES AGENDA --}}
    @if (Auth::check() && Auth::user()->hasRole('pruebas'))
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="card-title">Calendario de reservas</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ Auth::user()->profesor->nombres }}
                        <table id="reservas" class="table table-striped table-bordered table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nro</th>
                                    <th>Profesor</th>
                                    <th>Estudiante</th>
                                    <th>Fecha de la reserva</th>
                                    <th>Hora de reserva</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1; ?>
                                @foreach ($agendas as $clase)
                                    @if (Auth::user()->profesor->id == $clase->profesor_id)
                                        <tr>
                                            <td scope="row">{{ $contador++ }}</td>
                                            <td scope="row">
                                                {{ $clase->profesor->nombres . ' ' . $clase->profesor->apellidos }}
                                            </td>
                                            <td scope="row">
                                                {{ $clase->estudiante->nombres . ' ' . $clase->estudiante->apellidos }}
                                            </td>
                                            <td scope="row" class="text-center">
                                                {{ $clase->start->format('d M, Y') }}</td>
                                            <td scope="row" class="text-center">
                                                {{ $clase->end->format('H:i') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('js')

<script>
    window.Laravel = {
        isEstudiante: @json(Auth::check() && Auth::user()->estudiante !== null),
        routes: {
            horariosShowReservaProfesores: "{{ route('admin.horarios.show_reserva_profesores') }}",
        }
    };
</script>

    @vite(['resources/js/pages/dashboard.ts'])
    <script>
        // ---------------------------------------
        // Cargar contenido dinámico en selects
        // ---------------------------------------
        $('#profesor_select').on('change', function() {
            const curso_id = $(this).val();
            console.log(curso_id);
            const url = "{{ route('admin.horarios.show_datos_cursos', ':id') }}".replace(':id', curso_id);
            if (!curso_id) {
                $('#curso_info').html('');
                return;
            }
            $.get(url, function(data) {
                $('#curso_info').html(data);
            }).fail(() => alert('Error al obtener datos del curso'));
        });

        $('#cursoid').on('change', function() {
            const cursoid = $(this).val();
            if (!cursoid) return;
            const url = "{{ route('admin.obtenerProfesores', ':id') }}".replace(':id', cursoid);
            $.get(url, function(data) {
                if (Array.isArray(data)) {
                    $('#profesorid').empty().append(
                        '<option value="" selected disabled>Seleccione un Profesor</option>');
                    data.forEach(p => $('#profesorid').append(
                        `<option value="${p.id}">${p.nombres} ${p.apellidos}</option>`));
                } else {
                    alert('No se encontraron profesores');
                }
            }).fail(() => alert('Error al cargar los profesores'));
        });

        $('#estudiante_id').on('change', function() {
            const estudiante_id = $(this).val();
            if (!estudiante_id) return;
            const url = "{{ route('admin.obtenerCursos', ':id') }}".replace(':id', estudiante_id);
            $.get(url, function(data) {
                if (Array.isArray(data)) {
                    $('#cursoid').empty().append(
                        '<option value="" selected disabled>Seleccione un Curso</option>');
                    data.forEach(c => $('#cursoid').append(`<option value="${c.id}">${c.nombre}</option>`));
                } else {
                    alert('No se encontraron cursos');
                }
            }).fail(() => alert('Error al cargar los cursos'));
        });
    </script>

@stop
