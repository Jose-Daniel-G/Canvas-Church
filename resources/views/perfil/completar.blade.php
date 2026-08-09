@extends('adminlte::page')

@section('title', 'Completa tu perfil')

@section('content_header')
    <h1>Completa tu perfil</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="alert alert-info">
                Antes de continuar, necesitamos algunos datos para tu perfil de
                <b>{{ collect($roles)->map(fn ($r) => ucfirst($r))->implode(' / ') }}</b>.
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Mis datos</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('perfil.completar.store') }}" method="POST">
                        @csrf

                        @foreach ($campos as $nombre => $def)
                            <div class="form-group">
                                <label for="{{ $nombre }}">{{ $def['label'] }}</label>
                                @if ($def['requerido'])
                                    <b class="text-danger">*</b>
                                @endif

                                @if ($def['tipo'] === 'select')
                                    <select name="{{ $nombre }}" id="{{ $nombre }}" class="form-control"
                                        {{ $def['requerido'] ? 'required' : '' }}>
                                        <option value="" selected disabled>Seleccione</option>
                                        @foreach ($def['opciones'] as $opcion)
                                            <option value="{{ $opcion }}"
                                                {{ old($nombre, $valores[$nombre] ?? '') == $opcion ? 'selected' : '' }}>
                                                {{ $opcion }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($def['tipo'] === 'textarea')
                                    <textarea name="{{ $nombre }}" id="{{ $nombre }}" class="form-control" rows="2"
                                        {{ $def['requerido'] ? 'required' : '' }}>{{ old($nombre, $valores[$nombre] ?? '') }}</textarea>
                                @else
                                    <input type="{{ $def['tipo'] }}" name="{{ $nombre }}" id="{{ $nombre }}"
                                        class="form-control" value="{{ old($nombre, $valores[$nombre] ?? '') }}"
                                        {{ $def['requerido'] ? 'required' : '' }}>
                                @endif

                                @error($nombre)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-2">Guardar y continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
