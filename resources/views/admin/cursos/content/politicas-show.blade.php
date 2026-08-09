<div id="custom-tabs-three-politicas" class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Políticas del curso</h4>
            <p class="text-muted">Reglas y políticas establecidas para este curso.</p>

            @if($curso->politicas->count() > 0)
                <div class="accordion" id="accordionPoliticas">
                    @foreach($curso->politicas as $politica)
                        <div class="card mb-2">
                            <div class="card-header bg-light" id="heading{{ $loop->index }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" 
                                            type="button" 
                                            data-toggle="collapse" 
                                            data-target="#collapse{{ $loop->index }}" 
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $loop->index }}">
                                        <i class="fas fa-gavel text-primary mr-2"></i>
                                        <strong>{{ $politica->titulo_politica }}</strong>
                                        <i class="fas fa-chevron-down float-right mt-1"></i>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{ $loop->index }}" 
                                 class="collapse {{ $loop->first ? 'show' : '' }}" 
                                 aria-labelledby="heading{{ $loop->index }}" 
                                 data-parent="#accordionPoliticas">
                                <div class="card-body">
                                    <p class="mb-0" style="white-space: pre-wrap;">{{ $politica->contenido }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No se han definido políticas para este curso.
                </div>
            @endif

        </div>
    </div>
</div>