<div class="card-body">

    @if($cursos->isEmpty())
        <div class="alert alert-warning">
            Este estudiante no está inscrito en ningún curso.
        </div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Curso</th>
                    <th>Código</th>
                    <th>Periodo</th>
                    <th>Fecha de inscripción</th>
                    <th>Horas realizadas</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->nombre }}</td>
                        <td>{{ $curso->codigo ?? '-' }}</td>
                        <td>{{ $curso->periodo ?? '-' }}</td>

                        <td>
                            {{ $curso->pivot->fecha_inscripcion
                                ? \Carbon\Carbon::parse($curso->pivot->fecha_inscripcion)->format('d/m/Y')
                                : '-' }}
                        </td>

                        <td>
                            {{ $curso->pivot->horas_realizadas ?? 0 }}
                        </td>

                        <td>
                            @if(isset($curso->pivot->estado))
                                <span class="badge badge-info">
                                    {{ ucfirst($curso->pivot->estado) }}
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    Activo
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

<div class="card-footer">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        Volver
    </a>
</div>
