@extends('adminlte::page')

@section('title', 'Ver Curso - ' . $curso->nombre)

@section('header')
@stop

@section('content')
    <div class="container-fluid">
        
        {{-- CONTENIDO DEL CURSO --}}
        
        <div class="card mt-3">
            <div class="card-body">

                {{-- Navegación --}}
                @include('admin.cursos.content.nav-show')
                
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    @include('admin.cursos.content.descripcion-show')
                    @include('admin.cursos.content.objetivos-show')
                    @include('admin.cursos.content.bibliografia-show')
                    @include('admin.cursos.content.documentos-show')
                    @include('admin.cursos.content.calendario-show')
                    @include('admin.cursos.content.politicas-show')
                </div>

            </div>
        </div>

    </div>
@stop

@section('css')
    <style>
        .info-badge {
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
        }
        
        #nav-curso-fixed {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .content-card {
            transition: all 0.3s;
        }
        
        .content-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
@stop

@section('js')
    <script>
        // SCROLL suave entre secciones
        document.querySelectorAll('#nav-curso-fixed .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));
                if (!target) return;

                const nav = document.getElementById('nav-curso-fixed');
                const offset = nav ? nav.offsetHeight : 0;

                const top = target.getBoundingClientRect().top + window.scrollY - offset - 10;

                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });

                // Cambiar la clase activa
                document.querySelectorAll('#nav-curso-fixed .nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
            {{-- CALENDARIO --}}
        <script>
            let eventos = @json(
                $curso->calendarioEventos->map(function ($e) {
                    return [
                        'fecha' => $e->fecha->format('Y-m-d'),
                        'evento' => $e->titulo,
                        'tipo' => $e->tipo
                    ];
                })->values()
            ); 
            const calendarioBody = document.getElementById('calendario-body');
            const hiddenCalendario = document.getElementById('calendario_json');

            renderEventos();

            document.getElementById('addEvento').addEventListener('click', () => {
                const fecha = document.getElementById('evento_fecha').value;
                const nombre = document.getElementById('evento_nombre').value.trim();
                const tipo = document.getElementById('evento_tipo').value;

                if (!fecha || !nombre) {
                    alert('Por favor completa la fecha y el nombre del evento');
                    return;
                }

                eventos.push({
                    fecha,
                    evento: nombre,
                    tipo
                });
                renderEventos();

                document.getElementById('evento_fecha').value = '';
                document.getElementById('evento_nombre').value = '';
                document.getElementById('evento_tipo').value = 'examen';
            });

            function renderEventos() {
                calendarioBody.innerHTML = '';

                if (eventos.length === 0) {
                    calendarioBody.innerHTML = `
                <tr class="empty-row">
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                        No hay eventos programados. Usa el formulario superior para agregar uno.
                    </td>
                </tr>`;
                } else {
                    // Ordenar eventos por fecha
                    eventos.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));

                    eventos.forEach((e, i) => {
                        const tipoConfig = {
                            'examen': {
                                label: 'Examen',
                                badge: 'danger',
                                icon: 'fa-file-alt'
                            },
                            'parcial': {
                                label: 'Parcial',
                                badge: 'warning',
                                icon: 'fa-clipboard-list'
                            },
                            'entrega': {
                                label: 'Entrega',
                                badge: 'info',
                                icon: 'fa-upload'
                            },
                            'festivo': {
                                label: 'Festivo',
                                badge: 'success',
                                icon: 'fa-calendar-day'
                            },
                            'otro': {
                                label: 'Otro',
                                badge: 'secondary',
                                icon: 'fa-bookmark'
                            }
                        };

                        const config = tipoConfig[e.tipo] || tipoConfig['otro'];
                        const fechaFormateada = new Date(e.fecha + 'T00:00:00').toLocaleDateString('es-CO', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });

                        calendarioBody.innerHTML += `
                    <tr>
                        <td>
                            <i class="far fa-calendar-alt text-muted"></i>
                            <strong>${fechaFormateada}</strong>
                        </td>
                        <td>${e.evento}</td>
                        <td>
                            <span class="badge badge-${config.badge}">
                                <i class="fas ${config.icon}"></i> ${config.label}
                            </span>
                        </td>
                        
                        @can('admin.cursos.destroy')
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm btn-danger" 
                                    onclick="removeEvento(${i})"
                                    title="Eliminar evento">
                                <i class="fas fa-trash"></i>
                            </button>
                            </td>
                            @endcan
                    </tr>`;
                    });
                }

                hiddenCalendario.value = JSON.stringify(eventos);
            }
 
        </script>
@stop