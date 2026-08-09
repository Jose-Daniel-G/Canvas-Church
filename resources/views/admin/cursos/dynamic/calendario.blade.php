<div  id="custom-tabs-three-calendario"  class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Calendario académico</h4>
            <p class="text-muted">Programa los eventos importantes del curso: exámenes, entregas, parciales y festivos.</p>
            
            {{-- Formulario para agregar nuevo evento --}}
            <div class="card card-primary card-outline mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Agregar nuevo evento</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="evento_fecha">Fecha <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="evento_fecha" 
                                       class="form-control form-control-sm"
                                       min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="evento_nombre">Nombre del evento <span class="text-danger">*</span></label>
                                <input type="text" 
                                       id="evento_nombre" 
                                       class="form-control form-control-sm" 
                                       placeholder="Ej: Examen parcial - Unidad 1"
                                       maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="evento_tipo">Tipo <span class="text-danger">*</span></label>
                                <select id="evento_tipo" class="form-control form-control-sm">
                                    <option value="examen">📝 Examen</option>
                                    <option value="parcial">📋 Parcial</option>
                                    <option value="entrega">📤 Entrega</option>
                                    <option value="festivo">🎉 Festivo</option>
                                    <option value="otro">📌 Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-group mb-0 w-100">
                                <button type="button" id="addEvento" class="btn btn-success btn-sm btn-block">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de eventos programados --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Eventos programados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="tabla-calendario">
                            <thead class="thead-light">
                                <tr>
                                    <th width="20%">
                                        <i class="fas fa-calendar"></i> Fecha
                                    </th>
                                    <th width="50%">
                                        <i class="fas fa-file-alt"></i> Evento
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-tag"></i> Tipo
                                    </th>
                                    @can('admin.cursos.destroy')

                                    <th width="10%" class="text-center">
                                        <i class="fas fa-cog"></i> Acciones
                                    </th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody id="calendario-body">
                                {{-- JavaScript renderizará los eventos aquí --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Input hidden para enviar datos al servidor --}}
            <input type="hidden" name="calendario_json" id="calendario_json">
        </div>
    </div>
</div>