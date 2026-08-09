@extends('adminlte::page')

@section('title', ucfirst(auth()->user()->getRoleNames()->first()))

@section('content_header')
    <h1>Curso: Alabado sea Dios</h1>
@stop

@section('content')
    <div class="container">

        {{-- ENCABEZADO DEL CURSO --}}
        <div class="mb-4">
            <h2>Programación Web I</h2>
            <p class="text-muted">COD-PRG-101 · 2025-1</p>
        </div>

        {{-- NAVEGACIÓN DEL CURSO --}}
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-descripcion-tab" data-toggle="pill"
                    href="#custom-tabs-three-descripcion" role="tab" aria-controls="custom-tabs-three-descripcion"
                    aria-selected="false">Descripción</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-objetivos-tab" data-toggle="pill"
                    href="#custom-tabs-three-objetivos" role="tab" aria-controls="custom-tabs-three-objetivos"
                    aria-selected="false">Objetivos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-bibliografia-tab" data-toggle="pill"
                    href="#custom-tabs-three-bibliografia" role="tab" aria-controls="custom-tabs-three-bibliografia"
                    aria-selected="false">Bibliografia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-calendario-tab" data-toggle="pill"
                    href="#custom-tabs-three-calendario" role="tab" aria-controls="custom-tabs-three-calendario"
                    aria-selected="false">Calendario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-documentos-tab" data-toggle="pill"
                    href="#custom-tabs-three-documentos" role="tab" aria-controls="custom-tabs-three-documentos"
                    aria-selected="false">Documentos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-politicas-tab" data-toggle="pill"
                    href="#custom-tabs-three-politicas" role="tab" aria-controls="custom-tabs-three-politicas"
                    aria-selected="false">Politicas</a>
            </li>
        </ul>


        {{-- CONTENIDO DEL CURSO --}}
        <div class="card mt-3">
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-descripcion" role="tabpanel"
                        aria-labelledby="custom-tabs-three-descripcion-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- ================= DESCRIPCIÓN ================= --}}
                                <h4>Descripción del curso</h4>
                                <p>
                                    Este curso introduce al estudiante en los fundamentos de la
                                    programación web, abordando HTML, CSS, JavaScript y principios
                                    básicos de backend. Al finalizar, el estudiante será capaz de
                                    desarrollar aplicaciones web sencillas siguiendo buenas prácticas.
                                </p>

                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tabs-three-objetivos" role="tabpanel"
                        aria-labelledby="custom-tabs-three-objetivos-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">

                                {{-- ================= OBJETIVOS ================= --}}
                                <h4>Objetivos del curso</h4>

                                <div class="mb-3">
                                    <strong>Objetivo general</strong>
                                    <p>
                                        Desarrollar competencias básicas en programación web para
                                        la construcción de aplicaciones funcionales.
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <strong>Objetivo específico</strong>
                                    <p>
                                        Comprender la estructura de documentos HTML y su relación
                                        con hojas de estilo CSS.
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <strong>Objetivo específico</strong>
                                    <p>
                                        Implementar interactividad básica utilizando JavaScript.
                                    </p>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tabs-three-bibliografia" role="tabpanel"
                        aria-labelledby="custom-tabs-three-bibliografia-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- ================= BIBLIOGRAFÍA ================= --}}
                                <h4>Bibliografía</h4>

                                <ul class="list-group mb-4">
                                    <li class="list-group-item">
                                        <strong>HTML & CSS: Design and Build Websites</strong><br>
                                        <small class="text-muted">Jon Duckett · Libro</small>
                                    </li>

                                    <li class="list-group-item">
                                        <strong>JavaScript: The Good Parts</strong><br>
                                        <small class="text-muted">Douglas Crockford · Libro</small>
                                    </li>

                                    <li class="list-group-item">
                                        <strong>MDN Web Docs</strong><br>
                                        <small class="text-muted">Mozilla · Recurso web</small><br>
                                        <a href="#">https://developer.mozilla.org</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tabs-three-calendario" role="tabpanel"
                        aria-labelledby="custom-tabs-three-calendario-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- ================= CALENDARIO ================= --}}
                                <h4>Calendario académico</h4>

                                <table class="table table-bordered mb-4">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Evento</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>10/02/2025</td>
                                            <td>Introducción a la Web</td>
                                            <td>Clase</td>
                                        </tr>
                                        <tr>
                                            <td>25/02/2025</td>
                                            <td>Entrega Taller HTML</td>
                                            <td>Evaluación</td>
                                        </tr>
                                        <tr>
                                            <td>15/03/2025</td>
                                            <td>Parcial I</td>
                                            <td>Examen</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tabs-three-documentos" role="tabpanel"
                        aria-labelledby="custom-tabs-three-documentos-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- ================= DOCUMENTOS ================= --}}
                                <h4>Documentos del curso</h4>

                                <ul class="list-group mb-4">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Guía HTML Básico.pdf</span>
                                        <a href="#">Descargar</a>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Taller CSS.pdf</span>
                                        <a href="#">Descargar</a>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Introducción a JavaScript.pdf</span>
                                        <a href="#">Descargar</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade show" id="custom-tabs-three-politicas" role="tabpanel"
                        aria-labelledby="custom-tabs-three-politicas-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- ================= POLÍTICAS ================= --}}
                                <h4>Políticas del curso</h4>

                                <p>
                                    • La asistencia mínima requerida es del 80%.<br>
                                    • Las entregas fuera de la fecha establecida tendrán una penalización.<br>
                                    • El plagio será sancionado según el reglamento institucional.<br>
                                    • El respeto entre estudiantes y docentes es obligatorio.
                                </p>

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

    @stop
