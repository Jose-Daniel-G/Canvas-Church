<div id="custom-tabs-three-objetivos">
    <div class="row">
        <div class="col-12">
            <h4>Objetivos del curso</h4>
            {{-- OBJETIVO GENERAL --}}
            <h5 class="mt-3">Objetivo General</h5>
            <textarea name="objetivo_general" class="form-control mb-3" rows="3" required>{{ old('objetivo_general', optional($curso->objetivos->where('tipo','general')->first())->descripcion_obj) }}</textarea>
            <hr>
            {{-- OBJETIVOS ESPECÍFICOS --}}
            <h5>Objetivos Específicos</h5>
            <div class="input-group mb-2">
                <input type="text" id="input_especifico" class="form-control" placeholder="Escribe un objetivo específico">
                <button type="button" id="add_especifico" class="btn btn-success">Agregar</button>
            </div>

            <ul id="lista_especificos" class="list-group mb-3">
                {{-- Objetivos específicos agregados dinámicamente aparecerán aquí --}}
            </ul> 
            <input type="hidden" name="objetivos_especificos" id="input_hidden_especificos">

        </div>
    </div>
</div>


