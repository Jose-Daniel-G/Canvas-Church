<!-- Modal de Create -->
<div class="modal fade" id="createCursoModal" tabindex="-1" role="dialog" aria-labelledby="createCursoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ('admin.cursos.create')
                    <h5 class="modal-title" id="createCursoModalLabel">Crear Curso</h5>                    
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.cursos.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <label for="periodo">Periodo académico</label>
                            <input type="text" name="periodo" class="form-control" placeholder="Ej: 2026-1" required>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="codigo">Código</label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="codigo" id="codigo" value="{{ old('codigo') }}"
                                    placeholder="Ej: MAT-101" required>
                                @error('codigo')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre">Nombre del curso </label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}"
                                    required>
                                @error('nombre')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="horas_requeridas">horas requeridas </label><b class="text-danger">*</b>
                                <input type="number" class="form-control" name="horas_requeridas"
                                    value="{{ old('horas_requeridas') }}" required>
                                @error('horas_requeridas')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="estado">Estado </label><b class="text-danger">*</b>
                                <select name="estado" id="" class="form-control" required>
                                    <!-- Opción por defecto -->
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                @error('estado')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion </label><b class="text-danger">*</b>
                                        <textarea class="form-control" name="descripcion" required>{{ old('descripcion') }}</textarea>

                                        @error('descripcion')
                                            <small class="bg-danger text-white p-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar curso
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
