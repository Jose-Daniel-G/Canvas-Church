<div id="custom-tabs-three-politicas" class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Políticas del curso</h4>
            <p class="text-muted">Agrega, edita o elimina las políticas del curso.</p>
            
            {{-- Agregar política --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" id="politica_titulo" class="form-control"
                               placeholder="Ej: Tareas atrasadas">
                    </div>
                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea id="politica_contenido" class="form-control" rows="3"
                                  placeholder="Describe la política..."></textarea>
                    </div>
                    <button type="button" id="add_politica" class="btn btn-success">
                        + Agregar política
                    </button>
                </div>
            </div>
            
            {{-- Listado dinámico --}}
            <ul id="lista_politicas" class="list-group mb-3">
                {{-- JavaScript renderizará aquí --}}
            </ul>
            
            {{-- Hidden --}}
            <input type="hidden" name="politicas_json" id="politicas_json">
        </div>
    </div>
</div>