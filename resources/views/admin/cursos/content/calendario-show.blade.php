<div  id="custom-tabs-three-calendario"  class="mt-4">
    <div class="row">
        <div class="col-12">
            <h4>Calendario académico</h4>
            <p class="text-muted">Programa los eventos importantes del curso: exámenes, entregas, parciales y festivos.</p>
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