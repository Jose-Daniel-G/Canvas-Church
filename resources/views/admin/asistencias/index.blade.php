@extends('adminlte::page')

@section('title', 'Asistencia')

@section('content_header')
    <h2>Asistencia</h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lista</h3>
                </div>
                <div class="card-body">
                    <form id="asistenciaForm" action="{{ route('admin.asistencias.store') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table id="asistencias" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Clase</th>
                                        <th>Fecha</th>
                                        <th>Asistió</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clases as $clase)
                                        <tr>
                                            <td>{{ $clase->estudiante->nombres }}</td>
                                            <td>{{ $clase->title }}</td>
                                            <td>{{ $clase->start }}</td>
                                            <td>
                                        <input type="hidden" name="claseos[{{ $clase->id }}][estudiante_id]" 
                                                value="{{ $clase->estudiante->id }}">
                                                <input type="checkbox" name="claseos[{{ $clase->id }}][asistio]" 
                                                value="1" 
                                                {{ !empty($asistencias[$clase->id . '-' . $clase->estudiante->id]) && 
                                                    $asistencias[$clase->id . '-' . $clase->estudiante->id]->asistio ? 'checked' : '' }} 
                                                onchange="actualizarAsistencia({{ $clase->id }}, {{ $clase->estudiante->id }}, this.checked)">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
@endsection

@section('js')
    <script> 
        new DataTable('#asistencias', {responsive: true,autoWidth: false,scrollX:true,scrollX: true,});

        function actualizarAsistencia(claseoId, estudianteId, asistio) {

            const data = {                                              // Crear un objeto con los datos a enviar
                _token: '{{ csrf_token() }}',
                claseos: {[claseoId]: { estudiante_id: estudianteId, asistio: asistio ? 1 : 0}}
            };

            fetch("{{ route('admin.asistencias.store') }}", {            // Realizar la solicitud POST usando Fetch API
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la actualización');
                return response.json();
            })
            .then(data => {
                console.log('Asistencia actualizada correctamente');
            })
            .catch(error => {
                console.error('Hubo un problema con la actualización:', error);
            });
        }
    </script>
@endsection
