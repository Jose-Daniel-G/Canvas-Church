<div class="modal fade" id="editEstudianteModal" tabindex="-1" role="dialog" aria-labelledby="editEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEstudianteModalLabel">Editar Estudiante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEstudianteForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-nombres">Nombres </label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="nombres" id="edit-nombres" required>
                                @error('nombres')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-apellidos">Apellidos </label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="apellidos" id="edit-apellidos" required>
                                @error('apellidos')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-cc">CC </label><b class="text-danger">*</b>
                                <input type="number" class="form-control" name="cc" id="edit-cc" required>
                                @error('cc')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-telefono">Teléfono </label><b class="text-danger">*</b>
                                <input type="number" class="form-control" name="telefono" id="edit-telefono" required>
                                @error('telefono')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-genero">Sexo </label><b class="text-danger">*</b>
                                <select id="edit-genero" class="form-control" name="genero">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                @error('genero')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-email">Correo </label><b class="text-danger">*</b>
                                <input type="email" class="form-control" name="email" id="edit-email" required>
                                @error('email')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-direccion">Direccion </label><b class="text-danger">*</b>
                                <input type="address" class="form-control" name="direccion" id="edit-direccion" required>
                                @error('direccion')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-contacto_emergencia">Contacto Emergencia</label><b class="text-danger">*</b>
                                <input type="number" class="form-control" name="contacto_emergencia" id="edit-contacto_emergencia" required>
                            </div>
                            @error('contacto_emergencia')
                                <small class="bg-danger text-white p-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Cursos del estudiante:</label>
                            <div id="cursos-checkboxes" class="row"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-observaciones">Observaciones</label>
                                <textarea class="form-control" name="observaciones" id="edit-observaciones"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="form-group mb-0">
                                <input type="checkbox" id="edit-reset-password" name="reset_password">
                                <label for="edit-reset-password" class="ml-2">Restablecer contraseña a la cédula</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Actualizar estudiante</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>