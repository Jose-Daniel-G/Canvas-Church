{{-- NAVEGACIÓN DEL CURSO (MODO LECTURA) --}}
<div id="nav-curso-fixed" class="bg-white border-bottom" style="position: sticky; top: 57px; z-index: 1020;">
    <div class="d-flex justify-content-between align-items-center">
        <div class="mb-3">

            <h1>{{ $curso->nombre }}</h1>
            {{-- <p class="text-muted mb-0">
                <span class="badge badge-primary info-badge">{{ $curso->codigo }}</span>
                <span class="badge badge-info info-badge">{{ $curso->periodo }}</span>
                @if ($curso->estado)
                    <span class="badge badge-success info-badge">
                        <i class="fas fa-check-circle"></i> Activo
                    </span>
                @else
                    <span class="badge badge-secondary info-badge">
                        <i class="fas fa-times-circle"></i> Inactivo
                    </span>
                @endif 
            </p>--}}
        </div>
        <a href="{{ route('admin.cursos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>


    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#custom-tabs-three-descripcion">
                Descripción
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#custom-tabs-three-objetivos">
                Objetivos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#custom-tabs-three-bibliografia">
                Bibliografía
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="#custom-tabs-three-documentos">
                Documentos
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="#custom-tabs-three-calendario">
                Calendario
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#custom-tabs-three-politicas">
                Políticas
            </a>
        </li>
    </ul>
</div>
