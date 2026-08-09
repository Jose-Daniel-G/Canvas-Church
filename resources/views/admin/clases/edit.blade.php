<div class="modal fade" id="editClaseModal" tabindex="-1" role="dialog" aria-labelledby="editClaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClaseModalLabel">Editar clase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editClaseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-titulo">Título</label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="titulo" id="edit-titulo" required>
                                @error('titulo')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit-curso_id">Curso</label><b class="text-danger">*</b>
                                <select name="curso_id" id="edit-curso_id" class="form-control" required>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit-profesor_id">Profesor</label><b class="text-danger">*</b>
                                <select name="profesor_id" id="edit-profesor_id" class="form-control" required>
                                    @foreach ($profesores as $profesor)
                                        <option value="{{ $profesor->id }}">{{ $profesor->nombres }} {{ $profesor->apellidos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-fecha_hora_inicio">Inicio</label><b class="text-danger">*</b>
                                <input type="datetime-local" class="form-control" name="fecha_hora_inicio" id="edit-fecha_hora_inicio" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-fecha_hora_fin">Fin</label><b class="text-danger">*</b>
                                <input type="datetime-local" class="form-control" name="fecha_hora_fin" id="edit-fecha_hora_fin" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="edit-estado">Estado</label><b class="text-danger">*</b>
                                <select name="estado" id="edit-estado" class="form-control" required>
                                    <option value="programada">Programada</option>
                                    <option value="dictada">Dictada</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="edit-color">Color</label>
                                <input type="color" class="form-control" name="color" id="edit-color">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-aula">Aula</label>
                                <input type="text" class="form-control" name="aula" id="edit-aula">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-modalidad">Modalidad</label>
                                <input type="text" class="form-control" name="modalidad" id="edit-modalidad">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-link_virtual">Link virtual</label>
                                <input type="url" class="form-control" name="link_virtual" id="edit-link_virtual">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estudiantes</label>
                                <select name="estudiantes[]" id="edit-estudiantes" class="form-control select2-estudiantes" multiple>
                                    @foreach ($estudiantesDisponibles as $estudiante)
                                        <option value="{{ $estudiante->id }}">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Actualizar clase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
