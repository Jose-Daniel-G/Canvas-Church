{{-- Modal para cambiar estado de inscripción --}}
<div class="modal fade" id="modalEstado{{ $inscripcion->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.inscripciones.cambiar-estado', $inscripcion->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="modal-header bg-info">
                    <h5 class="modal-title">Cambiar Estado de Inscripción</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p><strong>Estudiante:</strong> {{ $inscripcion->nombres }} {{ $inscripcion->apellidos }}</p>
                    <p><strong>Curso:</strong> {{ $inscripcion->curso_nombre }}</p>

                    <hr>

                    <div class="form-group">
                        <label for="estado{{ $inscripcion->id }}">Nuevo Estado</label>
                        <select name="estado" id="estado{{ $inscripcion->id }}" class="form-control" required>
                            <option value="activo" {{ $inscripcion->estado == 'activo' ? 'selected' : '' }}>Activo
                            </option>
                            <option value="retirado" {{ $inscripcion->estado == 'retirado' ? 'selected' : '' }}>Retirado
                            </option>
                            <option value="aprobado" {{ $inscripcion->estado == 'aprobado' ? 'selected' : '' }}>Aprobado
                            </option>
                            <option value="reprobado" {{ $inscripcion->estado == 'reprobado' ? 'selected' : '' }}>
                                Reprobado</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>
</div>
