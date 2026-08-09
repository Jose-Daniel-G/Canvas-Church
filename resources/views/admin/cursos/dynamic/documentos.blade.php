                    <div class="tab-pane fade show" id="custom-tabs-three-documentos" role="tabpanel"
                        aria-labelledby="custom-tabs-three-documentos-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h4>Documentos del curso</h4>

                                <ul class="list-group">
                                    @forelse ($curso->documentos as $doc)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $doc->nombre }}</span>
                                            <a href="{{ route('documentos.descargar', $doc->id) }}">
                                                Descargar
                                            </a>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">
                                            No hay documentos disponibles.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
