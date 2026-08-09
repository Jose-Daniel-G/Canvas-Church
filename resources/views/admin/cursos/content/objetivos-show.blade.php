<div id="custom-tabs-three-objetivos" class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Objetivos del curso</h4>

            {{-- OBJETIVO GENERAL --}}
            <h5 class="mt-3">Objetivo General</h5>
            <div class="card border-primary content-card">
                <div class="card-body">
                    @php
                        $objetivoGeneral = $curso->objetivos->where('tipo', 'general')->first();
                    @endphp
                    
                    @if($objetivoGeneral)
                        <p class="mb-0">{{ $objetivoGeneral->descripcion_obj }}</p>
                    @else
                        <p class="text-muted mb-0">
                            <i class="fas fa-exclamation-triangle"></i>
                            No se ha definido un objetivo general.
                        </p>
                    @endif
                </div>
            </div>

            <hr>

            {{-- OBJETIVOS ESPECÍFICOS --}}
            <h5>Objetivos Específicos</h5>
            
            @php
                $objetivosEspecificos = $curso->objetivos->where('tipo', 'especifico');
            @endphp

            @if($objetivosEspecificos->count() > 0)
                <ul class="list-group mb-3">
                    @foreach($objetivosEspecificos as $objetivo)
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            {{ $objetivo->descripcion_obj }}
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    No se han definido objetivos específicos para este curso.
                </div>
            @endif

            <hr>
        </div>
    </div>
</div>