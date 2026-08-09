@extends('adminlte::page')

@section('title', 'Sin Curso Asignado')

@section('content_header')
    <h1>Mi Curso</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
                        <h3>No tienes un curso asignado actualmente</h3>
                        <p class="text-muted">
                            Por favor, contacta con la secretaría académica para que te asignen a un curso.
                        </p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left"></i> Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop