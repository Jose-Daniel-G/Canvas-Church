@extends('adminlte::page')

@section('title', 'Libro de Calificaciones')

@section('content_header')
    <h1>
        <i class="fas fa-book"></i> Libro de Calificaciones
    </h1>
@stop

@section('content')
    <div class="container-fluid">

        {{-- Selector de Curso --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Seleccionar Curso</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <select id="curso_selector" class="form-control">
                            <option value="">-- Seleccione un curso --</option>
                            <option value="1">MAT-101 - Matemáticas Básicas (2026-1)</option>
                            <option value="2">FIS-201 - Física I (2026-1)</option>
                            <option value="3">PROG-301 - Programación Web (2026-1)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success" onclick="exportarExcel()">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </button>
                        <button class="btn btn-danger" onclick="exportarPDF()">
                            <i class="fas fa-file-pdf"></i> Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas del Curso --}}
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>28</h3>
                        <p>Estudiantes Inscritos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>4.2</h3>
                        <p>Promedio General</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>85%</h3>
                        <p>Tasa de Aprobación</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>4</h3>
                        <p>Estudiantes en Riesgo</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de Calificaciones --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table"></i> Calificaciones por Estudiante
                </h3>
                <div class="card-tools">
                    <button class="btn btn-sm btn-info" onclick="calcularNotasFinales()">
                        <i class="fas fa-calculator"></i> Calcular Notas Finales
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-hover" id="tablaCalificaciones">
                    <thead class="thead-dark">
                        <tr>
                            <th rowspan="2" width="50" class="align-middle">#</th>
                            <th rowspan="2" width="200" class="align-middle">Estudiante</th>

                            {{-- Tareas (30%) --}}
                            <th colspan="3" class="text-center bg-info">Tareas (30%)</th>

                            {{-- Quizzes (20%) --}}
                            <th colspan="2" class="text-center bg-warning">Quizzes (20%)</th>

                            {{-- Parciales (30%) --}}
                            <th colspan="2" class="text-center bg-primary">Parciales (30%)</th>

                            {{-- Proyecto (20%) --}}
                            <th rowspan="2" class="align-middle text-center bg-success">Proyecto<br>(20%)</th>

                            {{-- Nota Final --}}
                            <th rowspan="2" width="100" class="align-middle text-center bg-dark">Nota Final</th>
                            <th rowspan="2" width="100" class="align-middle text-center">Estado</th>
                        </tr>
                        <tr>
                            {{-- Tareas --}}
                            <th class="text-center bg-info-light">T1</th>
                            <th class="text-center bg-info-light">T2</th>
                            <th class="text-center bg-info-light">T3</th>

                            {{-- Quizzes --}}
                            <th class="text-center bg-warning-light">Q1</th>
                            <th class="text-center bg-warning-light">Q2</th>

                            {{-- Parciales --}}
                            <th class="text-center bg-primary-light">P1</th>
                            <th class="text-center bg-primary-light">P2</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Estudiante 1 --}}
                        <tr>
                            <td class="text-center">1</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalEstudiante1">
                                    Juan Pérez García
                                </a>
                                <br>
                                <small class="text-muted">CC: 1234567890</small>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.5"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.8"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.2"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.0"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.5"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.3"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.7"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.6"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <strong class="text-success" style="font-size: 1.2em;">4.5</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">Aprobado</span>
                            </td>
                        </tr>

                        {{-- Estudiante 2 --}}
                        <tr>
                            <td class="text-center">2</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalEstudiante2">
                                    María González López
                                </a>
                                <br>
                                <small class="text-muted">CC: 9876543210</small>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.8"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.2"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.5"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.9"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.0"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.7"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.1"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="4.3"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <strong class="text-success" style="font-size: 1.2em;">3.9</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">Aprobado</span>
                            </td>
                        </tr>

                        {{-- Estudiante 3 - En Riesgo --}}
                        <tr class="table-warning">
                            <td class="text-center">3</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalEstudiante3">
                                    Carlos Rodríguez Sánchez
                                </a>
                                <br>
                                <small class="text-muted">CC: 5555555555</small>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.8"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.5"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.0"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.7"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.9"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.6"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="3.1"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.8"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <strong class="text-warning" style="font-size: 1.2em;">2.8</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-triangle"></i> En Riesgo
                                </span>
                            </td>
                        </tr>

                        {{-- Estudiante 4 - Reprobado --}}
                        <tr class="table-danger">
                            <td class="text-center">4</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modalEstudiante4">
                                    Ana Martínez Torres
                                </a>
                                <br>
                                <small class="text-muted">CC: 1111111111</small>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.0"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.3"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="1.8"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.5"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.2"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.1"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.4"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm text-center" value="2.6"
                                    min="0" max="5" step="0.1" style="width: 60px;">
                            </td>
                            <td class="text-center">
                                <strong class="text-danger" style="font-size: 1.2em;">2.2</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger">Reprobado</span>
                            </td>
                        </tr>

                        {{-- Más estudiantes... --}}
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                <i class="fas fa-ellipsis-h"></i> 24 estudiantes más...
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="2" class="text-right">PROMEDIOS:</th>
                            <th class="text-center">4.1</th>
                            <th class="text-center">4.3</th>
                            <th class="text-center">3.9</th>
                            <th class="text-center">3.8</th>
                            <th class="text-center">4.0</th>
                            <th class="text-center">3.7</th>
                            <th class="text-center">4.2</th>
                            <th class="text-center">4.1</th>
                            <th class="text-center"><strong>4.0</strong></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" onclick="guardarCalificaciones()">
                    <i class="fas fa-save"></i> Guardar Todas las Calificaciones
                </button>
                <button class="btn btn-info" onclick="generarReporte()">
                    <i class="fas fa-chart-bar"></i> Generar Reporte
                </button>
            </div>
        </div>

        {{-- Gráfico de Distribución de Notas --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar"></i> Distribución de Notas Finales
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="chartDistribucion" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i> Rendimiento por Categoría
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="chartCategoria" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('css')
    <style>
        .bg-info-light {
            background-color: #d1ecf1 !important;
        }

        .bg-warning-light {
            background-color: #fff3cd !important;
        }

        .bg-primary-light {
            background-color: #cfe2ff !important;
        }

        #tablaCalificaciones input {
            display: inline-block;
            margin: 0 auto;
        }

        #tablaCalificaciones th {
            vertical-align: middle !important;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Gráfico de Distribución
        const ctxDist = document.getElementById('chartDistribucion').getContext('2d');
        new Chart(ctxDist, {
            type: 'bar',
            data: {
                labels: ['0.0-1.0', '1.1-2.0', '2.1-3.0', '3.1-4.0', '4.1-5.0'],
                datasets: [{
                    label: 'Cantidad de Estudiantes',
                    data: [0, 2, 4, 12, 10],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(40, 167, 69, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 2
                        }
                    }
                }
            }
        });

        // Gráfico de Categorías
        const ctxCat = document.getElementById('chartCategoria').getContext('2d');
        new Chart(ctxCat, {
            type: 'pie',
            data: {
                labels: ['Tareas', 'Quizzes', 'Parciales', 'Proyecto'],
                datasets: [{
                    data: [4.2, 3.9, 3.9, 4.1],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(0, 123, 255, 0.7)',
                        'rgba(40, 167, 69, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@stop
