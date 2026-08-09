@extends('adminlte::page')

@section('title', 'Contenido - ' . $curso->nombre)

@section('content_header')
    <h1>Contenido del Curso</h1>
@stop

@section('content')
    <div class="container-fluid">
        
        {{-- Reutiliza los partials del admin pero en modo solo lectura --}}
        <div class="card">
            <div class="card-body">
                
                {{-- Puedes incluir los partials de show --}}
                @include('admin.cursos.partials.descripcion-show')
                @include('admin.cursos.partials.bibliografia-show')
                @include('admin.cursos.partials.documentos-show')
                
            </div>
        </div>

    </div>
@stop