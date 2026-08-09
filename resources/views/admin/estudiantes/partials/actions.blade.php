<div class="btn-group" role="group" aria-label="Acciones">
    <a href="#" class="btn btn-warning btn-sm mr-1" data-id="{{ $estudiante->id }}" data-toggle="modal"
        data-target="#editEstudianteModal" title="Editar">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('admin.estudiantes.toggleStatus', $estudiante->user->id) }}" method="POST"
        style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn {{ $estudiante->user->status ? 'btn-success' : 'btn-danger' }}">
            {!! $estudiante->user->status
                ? '<i class="fa-solid fa-square-check"></i>'
                : '<i class="fa-solid fa-circle-xmark"></i>' !!}
        </button>
    </form>
    @if (Auth::user()->hasRole('root'))
        <form id="delete-form-{{ $estudiante->id }}" action="{{ route('admin.estudiantes.destroy', $estudiante->id) }}"
            method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-delete">
        <i class="fas fa-trash"></i>
    </button>
        </form>
    @endif
</div>
