@extends('adminlte::page')

@section('title', 'Mis Calificaciones')

@section('content_header')
    <h1>
        <i class="fas fa-star"></i> Mis Calificaciones
    </h1>
@stop

@section('content')
    <div class="container-fluid">

        {{-- Información del Curso --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">
                    <i class="fas fa-book"></i> PROG-301 - Programación Web
                </h3>
                <div class="card-tools">
                    <span class="badge badge-light">Período: 2026-1</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon">
                                <i class="fas fa-trophy"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Mi Nota Final</span>
                                <span class="info-box-number">4.5</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Promedio Curso</span>
                                <span class="info-box-number">4.2</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tareas Calificadas</span>
                                <span class="info-box-number">8/10</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon">
                                <i class="fas fa-percentage"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Porcentaje Completado</span>
                                <span class="info-box-number">80%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Desglose de Calificaciones --}}
        <div class="row">
            {{-- Tareas --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i> Tareas (30%)
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tarea</th>
                                    <th width="100" class="text-center">Nota</th>
                                    <th width="120" class="text-center">Peso</th>
                                    <th width="100" class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tarea 1: HTML Básico</td>
                                    <td class="text-center"><strong>4.5</strong></td>
                                    <td class="text-center">10%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tarea 2: CSS Avanzado</td>
                                    <td class="text-center"><strong>4.8</strong></td>
                                    <td class="text-center">10%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tarea 3: JavaScript</td>
                                    <td class="text-center"><strong>4.2</strong></td>
                                    <td class="text-center">10%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th>Promedio Tareas</th>
                                    <th class="text-center">4.5</th>
                                    <th class="text-center">30%</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Quizzes --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">
                            <i class="fas fa-question-circle"></i> Quizzes (20%)
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Quiz</th>
                                    <th width="100" class="text-center">Nota</th>
                                    <th width="120" class="text-center">Peso</th>
                                    <th width="100" class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Quiz 1: Fundamentos</td>
                                    <td class="text-center"><strong>4.0</strong></td>
                                    <td class="text-center">10%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quiz 2: Frameworks</td>
                                    <td class="text-center"><strong>4.5</strong></td>
                                    <td class="text-center">10%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th>Promedio Quizzes</th>
                                    <th class="text-center">4.25</th>
                                    <th class="text-center">20%</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Parciales --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt"></i> Parciales (30%)
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Parcial</th>
                                    <th width="100" class="text-center">Nota</th>
                                    <th width="120" class="text-center">Peso</th>
                                    <th width="100" class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Parcial I</td>
                                    <td class="text-center"><strong>4.3</strong></td>
                                    <td class="text-center">15%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Parcial II</td>
                                    <td class="text-center"><strong>4.7</strong></td>
                                    <td class="text-center">15%</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Calificada</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th>Promedio Parciales</th>
                                    <th class="text-center">4.5</th>
                                    <th class="text-center">30%</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('chartProgreso').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'Q1', 'Q2', 'P1', 'P2', 'Proyecto'],
                datasets: [{
                    label: 'Mis Notas',
                    data: [4.5, 4.8, 4.2, 4.0, 4.5, 4.3, 4.7, 4.6],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4
                }, {
                    label: 'Promedio del Curso',
                    data: [4.1, 4.3, 3.9, 3.8, 4.0, 3.7, 4.2, 4.1],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 0.5
                        }
                    }
                }
            }
        });
    </script>
@stop
