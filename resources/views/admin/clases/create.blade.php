<div class="modal fade" id="createClaseModal" tabindex="-1" role="dialog" aria-labelledby="createClaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClaseModalLabel">Nueva clase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.clases.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo">Título</label><b class="text-danger">*</b>
                                <input type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="curso_id">Curso</label><b class="text-danger">*</b>
                                <select name="curso_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="profesor_id">Profesor</label><b class="text-danger">*</b>
                                <select name="profesor_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($profesores as $profesor)
                                        <option value="{{ $profesor->id }}">{{ $profesor->nombres }} {{ $profesor->apellidos }}</option>
                                    @endforeach
                                </select>
                                @error('profesor_id')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_hora_inicio">Inicio</label><b class="text-danger">*</b>
                                <input type="datetime-local" class="form-control" name="fecha_hora_inicio" required>
                                @error('fecha_hora_inicio')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_hora_fin">Fin</label><b class="text-danger">*</b>
                                <input type="datetime-local" class="form-control" name="fecha_hora_fin" required>
                                @error('fecha_hora_fin')
                                    <small class="bg-danger text-white p-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado">Estado</label><b class="text-danger">*</b>
                                <select name="estado" class="form-control" required>
                                    <option value="programada" selected>Programada</option>
                                    <option value="dictada">Dictada</option>
                                    <option value="cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="color" class="form-control" name="color" value="#3788d8">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="aula">Aula</label>
                                <input type="text" class="form-control" name="aula" value="{{ old('aula') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <input type="text" class="form-control" name="modalidad" value="{{ old('modalidad') }}" placeholder="Presencial / Virtual">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="link_virtual">Link virtual</label>
                                <input type="url" class="form-control" name="link_virtual" value="{{ old('link_virtual') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Estudiantes</label>
                                <select name="estudiantes[]" class="form-control select2-estudiantes" multiple>
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
                                <button type="submit" class="btn btn-primary">Registrar clase</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
