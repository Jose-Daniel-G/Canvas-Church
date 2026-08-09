<div id="custom-tabs-three-bibliografia">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h4>Bibliografía</h4>

            <ul class="list-group" id="bibliografias-container">
                @foreach ($curso->bibliografias as $i => $item)
                    <li class="list-group-item">
                        {{-- ID oculto --}}
                        <input type="hidden" name="bibliografias[{{ $i }}][id]" value="{{ $item->id }}">

                        <div class="row">
                            <div class="col-md">
                                <label>Título</label>
                                <input type="text" name="bibliografias[{{ $i }}][titulo]" class="form-control"
                                    value="{{ old("bibliografias.$i.titulo", $item->titulo) }}" required>
                            </div>

                            <div class="col-md">
                                <label>Autor</label>
                                <input type="text" name="bibliografias[{{ $i }}][autor]" class="form-control"
                                    value="{{ old("bibliografias.$i.autor", $item->autor) }}">
                            </div>

                            <div class="col-md-2">
                                <label>Tipo</label>
                                <select name="bibliografias[{{ $i }}][tipo]" class="form-control">
                                    <option value="libro" @selected($item->tipo == 'libro')>Libro</option>
                                    <option value="articulo" @selected($item->tipo == 'articulo')>Artículo</option>
                                    <option value="web" @selected($item->tipo == 'web')>Web</option>
                                </select>
                            </div>

                            <div class="col-md">
                                <label>URL</label>
                                <input type="url" name="bibliografias[{{ $i }}][url]" class="form-control"
                                    value="{{ old("bibliografias.$i.url", $item->url) }}">
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addBibliografia">
                + Agregar bibliografía
            </button>
        </div>
    </div>
</div>