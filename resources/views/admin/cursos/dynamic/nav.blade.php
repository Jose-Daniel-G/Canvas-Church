{{-- NAVEGACIÓN DEL CURSO --}}
        
<div id="nav-curso-fixed" class="bg-white border-bottom"  style="position: sticky; top: 57px; z-index: 1020;">
    <h1>Curso: {{ $curso->nombre }}</h1>

<p class="text-muted">{{ $curso->codigo }} · {{ $curso->periodo }}</p>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#custom-tabs-three-descripcion">Descripción</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#custom-tabs-three-objetivos">Objetivos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#custom-tabs-three-bibliografia">Bibliografía</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#custom-tabs-three-calendario">Calendario</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#custom-tabs-three-documentos">Documentos</a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#custom-tabs-three-politicas">Políticas</a>
    </li>
</ul>
</div>
