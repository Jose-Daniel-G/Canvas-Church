<div id="custom-tabs-three-descripcion" class="mt-4">
    <div class="row">
        <div class="col-12">
            {{-- ================= DESCRIPCIÓN ================= --}}
            <h4>Descripción del curso</h4>

            {{-- Código y Nombre del curso --}}
            <div class="form-group">
                <div class="row">
                    {{-- Código del curso --}}
                    <div class="col-md-4">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" id="codigo" class="form-control"
                            placeholder="COD-001"
                            value="{{ old('codigo', $curso->codigo) }}" required>
                    </div>

                    {{-- Nombre del curso --}}
                    <div class="col-md-4">
                        <label for="nombre">Nombre del curso</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            placeholder="Escribe el nombre"
                            value="{{ old('nombre', $curso->nombre) }}" required>
                    </div>
                                        {{-- Período académico --}}
                    <div class="col-md-4">
                        <label for="periodo">Período académico</label>
                        <select name="periodo" id="periodo" class="form-control" required>
                            <option value="">Seleccione un período</option>
                            <option value="2026-1" {{ old('periodo', $curso->periodo) == '2026-1' ? 'selected' : '' }}>2026 - I</option>
                            <option value="2026-2" {{ old('periodo', $curso->periodo) == '2026-2' ? 'selected' : '' }}>2026 - II</option>
                            <option value="2027-1" {{ old('periodo', $curso->periodo) == '2027-1' ? 'selected' : '' }}>2027 - I</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Descripción y Período Académico --}}
            <div class="form-group">
                <div class="row">
                    {{-- Descripción --}}
                    <div class="col-md-12">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                            placeholder="Escribe la descripción del curso..." required>{{ old('descripcion', $curso->descripcion) }}</textarea>
                    </div>


                </div>
            </div>

            <hr>
        </div>
    </div>
</div>
