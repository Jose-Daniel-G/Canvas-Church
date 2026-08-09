{{-- resources/views/courses/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Curso - Programación Web Avanzada')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Módulo 1: Introducción</h1>
            <small class="text-muted">Lección 1.3 - Conceptos básicos</small>
        </div>
        <div>
            <span class="badge badge-primary">Estudiante</span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Contenido principal --}}
            <div class="col-md-12">
                {{-- Video Player --}}
                {{-- <div class="card">
                <div class="card-body p-0">
                    <div class="bg-dark d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-play-circle fa-5x text-white" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div> --}}

                {{-- Tabs de navegación --}}
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#tab-overview" role="tab">
                                    <i class="fas fa-info-circle"></i> Resumen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#tab-tasks" role="tab">
                                    <i class="fas fa-tasks"></i> Tareas <span class="badge badge-warning">3</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#tab-resources" role="tab">
                                    <i class="fas fa-file-alt"></i> Recursos
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#tab-discussion" role="tab">
                                    <i class="fas fa-comments"></i> Discusión
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            {{-- Tab Resumen --}}
                            <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                                <h4>Conceptos Básicos de Desarrollo Web</h4>
                                <p class="text-muted">
                                    <i class="far fa-clock"></i> Duración: 45 minutos |
                                    <i class="fas fa-signal"></i> Dificultad: Principiante
                                </p>

                                <h5 class="mt-4">Descripción</h5>
                                <p>En esta lección aprenderás los conceptos fundamentales del desarrollo web moderno.
                                    Exploraremos cómo funcionan las tecnologías web, la arquitectura cliente-servidor, y los
                                    lenguajes principales que usaremos a lo largo del curso.</p>

                                <h5 class="mt-4">Objetivos de aprendizaje</h5>
                                <ul>
                                    <li>Comprender la arquitectura cliente-servidor</li>
                                    <li>Identificar los roles de HTML, CSS y JavaScript</li>
                                    <li>Conocer el proceso de desarrollo web</li>
                                    <li>Configurar herramientas de desarrollo</li>
                                </ul>

                                <h5 class="mt-4">Contenido de la lección</h5>
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-video text-primary"></i> Introducción (5 min)
                                        </span>
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-video text-primary"></i> Arquitectura web (15 min)
                                        </span>
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-video text-primary"></i> Tecnologías principales (20 min)
                                        </span>
                                        <span class="badge badge-primary">Actual</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-video text-primary"></i> Resumen y siguientes pasos (5 min)
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check"></i> Marcar como completada
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Siguiente lección
                                    </button>
                                </div>
                            </div>

                            {{-- Tab Tareas --}}
                            <div class="tab-pane fade" id="tab-tasks" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div id="tasks-list">
                                            <h4 class="mb-3">Tareas del Módulo</h4>

                                            {{-- Tarea 1 --}}
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h5>Tarea 1: Análisis de Arquitectura Web</h5>
                                                            <p class="text-muted">Investiga y documenta cómo funciona la
                                                                arquitectura cliente-servidor en aplicaciones web modernas.
                                                            </p>
                                                        </div>
                                                        <span class="badge badge-success">Completada</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <small class="text-muted">
                                                            <i class="far fa-calendar"></i> Entrega: 20 Ene 2026
                                                        </small>
                                                        <small class="text-success font-weight-bold">
                                                            Calificación: 95/100
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Tarea 2 --}}
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h5>Tarea 2: Primera Página HTML</h5>
                                                            <p class="text-muted">Crea tu primera página web utilizando
                                                                HTML5
                                                                semántico con al menos 5 elementos diferentes.</p>
                                                        </div>
                                                        <span class="badge badge-info">Calificada</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <small class="text-muted">
                                                            <i class="far fa-calendar"></i> Entrega: 22 Ene 2026
                                                        </small>
                                                        <small class="text-primary font-weight-bold">
                                                            Calificación: 88/100
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Tarea 3 --}}
                                            <div class="card card-primary card-outline mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h5>Tarea 3: Proyecto Integrador - Portfolio Personal</h5>
                                                            <p class="text-muted">Desarrolla un portfolio personal que
                                                                incluya
                                                                información sobre ti, tus proyectos y formas de contacto.
                                                            </p>
                                                        </div>
                                                        <span class="badge badge-warning">Pendiente</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <small class="text-muted">
                                                            <i class="far fa-calendar"></i> Fecha límite: 25 Ene 2026
                                                        </small>
                                                        <small class="text-danger font-weight-bold">
                                                            Faltan 10 días
                                                        </small>
                                                    </div>
                                                    <div class="progress mt-2" style="height: 6px;">
                                                        <div class="progress-bar" role="progressbar" style="width: 0%">
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-sm btn-primary" onclick="showTaskDetail()">
                                                            <i class="fas fa-eye"></i> Ver detalles y entregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Vista de detalle de tarea --}}
                                        <div id="task-detail" style="display: none;">
                                            <button class="btn btn-link pl-0" onclick="hideTaskDetail()">
                                                <i class="fas fa-arrow-left"></i> Volver a tareas
                                            </button>

                                            <div class="card card-primary card-outline mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Tarea 3: Proyecto Integrador - Portfolio Personal
                                                    </h3>
                                                    <div class="card-tools">
                                                        <span class="badge badge-warning">Pendiente</span>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>Fecha límite:</strong> 25 Enero 2026
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <span class="text-danger">
                                                                <i class="far fa-clock"></i> Faltan 10 días
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h5>Descripción de la tarea</h5>
                                                    <p>Desarrolla un portfolio personal profesional que sirva como tu carta
                                                        de
                                                        presentación en el mundo digital. Este proyecto integrará todos los
                                                        conceptos aprendidos hasta ahora.</p>

                                                    <h5 class="mt-4">Requisitos</h5>
                                                    <ul>
                                                        <li>Estructura HTML5 semántica correcta (header, nav, main, section,
                                                            footer)</li>
                                                        <li>Diseño responsive que funcione en móviles, tablets y desktop
                                                        </li>
                                                        <li>Sección "Sobre mí" con tu foto y descripción</li>
                                                        <li>Galería de al menos 3 proyectos (pueden ser ficticios)</li>
                                                        <li>Formulario de contacto funcional</li>
                                                        <li>Navegación suave entre secciones</li>
                                                        <li>Uso de CSS Grid o Flexbox para el layout</li>
                                                        <li>Al menos 3 animaciones CSS</li>
                                                        <li>Código limpio y comentado</li>
                                                    </ul>

                                                    <h5 class="mt-4">Criterios de evaluación</h5>
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Criterio</th>
                                                                <th width="100">Puntos</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Estructura HTML semántica</td>
                                                                <td>20 pts</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Diseño responsive</td>
                                                                <td>25 pts</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Estética y creatividad</td>
                                                                <td>20 pts</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Funcionalidad completa</td>
                                                                <td>20 pts</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Código limpio y comentado</td>
                                                                <td>15 pts</td>
                                                            </tr>
                                                            <tr class="font-weight-bold">
                                                                <td>Total</td>
                                                                <td>100 pts</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <h5 class="mt-4">Recursos de apoyo</h5>
                                                    <div class="list-group mb-3">
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            <i class="fas fa-file-pdf text-danger"></i> Guía de HTML5
                                                            Semántico.pdf
                                                        </a>
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            <i class="fas fa-file-code text-primary"></i> Template inicial
                                                            del
                                                            proyecto
                                                        </a>
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            <i class="fas fa-video text-success"></i> Video tutorial: CSS
                                                            Grid
                                                            y Flexbox
                                                        </a>
                                                    </div>

                                                    <h5 class="mt-4">Entrega de la tarea</h5>
                                                    <div class="form-group">
                                                        <label>Subir archivo</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="taskFile">
                                                            <label class="custom-file-label" for="taskFile">Seleccionar
                                                                archivo ZIP</label>
                                                        </div>
                                                        <small class="form-text text-muted">
                                                            Formatos aceptados: .zip, .rar (máx. 50MB)
                                                        </small>
                                                    </div>

                                                    <div class="callout callout-info">
                                                        <h5><i class="icon fas fa-info"></i> Nota:</h5>
                                                        Comprime todos tus archivos HTML, CSS, JS e imágenes en un único
                                                        archivo
                                                        ZIP antes de subirlo.
                                                    </div>

                                                    <div class="form-group">
                                                        <label>O pega el enlace de tu repositorio</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fab fa-github"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                placeholder="https://github.com/tu-usuario/portfolio">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Comentarios adicionales (opcional)</label>
                                                        <textarea class="form-control" rows="4" placeholder="Agrega cualquier comentario o nota para el instructor..."></textarea>
                                                    </div>

                                                    <div class="mt-4">
                                                        <button class="btn btn-success">
                                                            <i class="fas fa-paper-plane"></i> Enviar tarea
                                                        </button>
                                                        <button class="btn btn-secondary">
                                                            <i class="fas fa-save"></i> Guardar borrador
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Historial de entregas</h3>
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-muted">No hay entregas previas para esta tarea.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        {{-- Card de progreso --}}
                                        <div class="card card-widget widget-user-2">
                                            <div class="card-header bg-gradient-primary">
                                                <h3 class="card-title">Tu progreso</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <h1 class="display-4 text-primary">67%</h1>
                                                    <p class="text-muted">Tareas completadas</p>
                                                </div>
                                                <div class="progress mb-3">
                                                    <div class="progress-bar bg-primary" style="width: 67%"></div>
                                                </div>
                                                <ul class="list-unstyled">
                                                    <li class="d-flex justify-content-between mb-2">
                                                        <span>Completadas</span>
                                                        <strong>2/3</strong>
                                                    </li>
                                                    <li class="d-flex justify-content-between mb-2">
                                                        <span>Promedio</span>
                                                        <strong>91.5</strong>
                                                    </li>
                                                    <li class="d-flex justify-content-between">
                                                        <span>Mejor calificación</span>
                                                        <strong class="text-success">95</strong>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        {{-- Próximas fechas --}}
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="far fa-calendar-alt"></i> Próximas fechas
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="font-weight-bold text-danger">25 Ene 2026</div>
                                                    <small>Tarea 3: Portfolio Personal</small>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="font-weight-bold">28 Ene 2026</div>
                                                    <small>Examen Módulo 1</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tab Recursos --}}
                            @include('admin.cursos.partials.quemadapartials.tabrecursos')
                            {{-- Discusion Recursos --}}
                            @include('admin.cursos.partials.quemadapartials.discussion')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
<script>
    function showTaskDetail() {
        document.getElementById('tasks-list').style.display = 'none';
        document.getElementById('task-detail').style.display = 'block';
    }

    function hideTaskDetail() {
        document.getElementById('task-detail').style.display = 'none';
        document.getElementById('tasks-list').style.display = 'block';
    }
</script>
@stop
