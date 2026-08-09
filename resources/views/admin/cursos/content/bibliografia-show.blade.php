<div id="custom-tabs-three-bibliografia" class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Bibliografía</h4>

            @if($curso->bibliografias->count() > 0)
                <ul class="list-group">
                    @foreach($curso->bibliografias as $item)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <strong>
                                        <i class="fas fa-book text-primary mr-2"></i>
                                        {{ $item->titulo }}
                                    </strong>
                                    
                                    @if($item->autor)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> {{ $item->autor }}
                                        </small>
                                    @endif
                                </div>
                                
                                @if($item->url)
                                    <a href="{{ $item->url }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary ml-2">
                                        <i class="fas fa-external-link-alt"></i> Ver recurso
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    No hay bibliografía registrada para este curso.
                </div>
            @endif

            <hr>
        </div>
    </div>
</div>