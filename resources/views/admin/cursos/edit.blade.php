    @extends('adminlte::page')

    @section('title', ucfirst(auth()->user()->getRoleNames()->first()))

    @section('content')
        <div class="container-fluid">
            {{-- CONTENIDO DEL CURSO --}}
            <div class="card mt-3">
                <div class="card-body">

                    {{-- Navegación --}}
                    @include('admin.cursos.dynamic.nav')
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <form id="form_curso" action="{{ route('admin.cursos.update', $curso->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('admin.cursos.dynamic.descripcion')
                            @include('admin.cursos.dynamic.objetivos')
                            @include('admin.cursos.dynamic.bibliografia')
                            @include('admin.cursos.dynamic.calendario')
                            @include('admin.cursos.dynamic.politicas')
                            <input type="submit" value="Enviar" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @stop

    @section('js')
        <script>
            // SCROLL 
            document.querySelectorAll('#nav-curso-fixed .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // ID del div objetivo
                    const target = document.querySelector(this.getAttribute('href'));
                    if (!target) return;

                    // Altura del navbar sticky
                    const nav = document.getElementById('nav-curso-fixed');
                    const offset = nav ? nav.offsetHeight : 0;

                    // Posición exacta para scroll
                    const top = target.getBoundingClientRect().top + window.scrollY - offset -
                        10; // -10 para un pequeño margen

                    window.scrollTo({
                        top: top,
                        behavior: 'smooth'
                    });

                    // Cambiar la clase activa de las pestañas
                    document.querySelectorAll('#nav-curso-fixed .nav-link').forEach(l => l.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
            });
        </script>
        {{-- JS Objetivos --}}
        <script>
            const listaEspecificos = document.getElementById('lista_especificos');
            const inputEspecifico = document.getElementById('input_especifico');

            // 1. Inicializar el array con los datos que YA existen en la BD
            let especificos = @json($curso->objetivos->where('tipo', 'especifico')->pluck('descripcion_obj')->values());

            // 2. Renderizar los existentes al cargar la página
            renderEspecificos();

            document.getElementById('add_especifico').addEventListener('click', () => {
                const valor = inputEspecifico.value.trim();
                if (!valor) return alert('Escribe un objetivo específico.');

                especificos.push(valor);
                renderEspecificos();
                inputEspecifico.value = '';
            });

            function renderEspecificos() {
                listaEspecificos.innerHTML = '';
                especificos.forEach((obj, i) => {
                    listaEspecificos.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${obj}
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEspecifico(${i})">✖</button>
                </li>`;
                });
                // Actualizar el input hidden inmediatamente para seguridad
                document.getElementById('input_hidden_especificos').value = JSON.stringify(especificos);
            }

            window.removeEspecifico = function(index) {
                especificos.splice(index, 1);
                renderEspecificos();
            }

            // Asegurar que el input hidden se llene antes del submit
            document.getElementById('form_curso').addEventListener('submit', function(e) {
                document.getElementById('input_hidden_especificos').value = JSON.stringify(especificos);
            });
        </script>
        <script>
            const objetivosExistentes = @json($curso->objetivos->where('tipo', 'especifico')->pluck('descripcion_obj'));
        </script>
        {{-- BIBLIOGRAFIAS --}}
        <script>
            let index = {{ $curso->bibliografias->count() }};

            document.getElementById('addBibliografia').addEventListener('click', () => {
                const container = document.getElementById('bibliografias-container');

                container.insertAdjacentHTML('beforeend', `
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4">
                                <label>Título</label>
                                <input type="text" name="bibliografias[${index}][titulo]" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <label>Autor</label>
                                <input type="text" name="bibliografias[${index}][autor]" class="form-control">
                            </div>
                            <div class="col-2">
                                <label>Tipo</label>
                                <select name="bibliografias[${index}][tipo]" class="form-control">
                                    <option value="libro">Libro</option>
                                    <option value="articulo">Artículo</option>
                                    <option value="web">Web</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label>URL</label>
                                <input type="url" name="bibliografias[${index}][url]" class="form-control">
                            </div>
                        </div>
                    </li>
                `);

                index++;
            });
        </script>

        {{-- CALENDARIO --}}
        <script>
            let eventos = @json(
                $curso->calendarioEventos->map(function ($e) {
                    return [
                        'fecha' => $e->fecha->format('Y-m-d'),
                        'evento' => $e->titulo,
                        'tipo' => $e->tipo
                    ];
                })->values()
            ); 
            const calendarioBody = document.getElementById('calendario-body');
            const hiddenCalendario = document.getElementById('calendario_json');

            renderEventos();

            document.getElementById('addEvento').addEventListener('click', () => {
                const fecha = document.getElementById('evento_fecha').value;
                const nombre = document.getElementById('evento_nombre').value.trim();
                const tipo = document.getElementById('evento_tipo').value;

                if (!fecha || !nombre) {
                    alert('Por favor completa la fecha y el nombre del evento');
                    return;
                }

                eventos.push({
                    fecha,
                    evento: nombre,
                    tipo
                });
                renderEventos();

                document.getElementById('evento_fecha').value = '';
                document.getElementById('evento_nombre').value = '';
                document.getElementById('evento_tipo').value = 'examen';
            });

            function renderEventos() {
                calendarioBody.innerHTML = '';

                if (eventos.length === 0) {
                    calendarioBody.innerHTML = `
                <tr class="empty-row">
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                        No hay eventos programados. Usa el formulario superior para agregar uno.
                    </td>
                </tr>`;
                } else {
                    // Ordenar eventos por fecha
                    eventos.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));

                    eventos.forEach((e, i) => {
                        const tipoConfig = {
                            'examen': {
                                label: 'Examen',
                                badge: 'danger',
                                icon: 'fa-file-alt'
                            },
                            'parcial': {
                                label: 'Parcial',
                                badge: 'warning',
                                icon: 'fa-clipboard-list'
                            },
                            'entrega': {
                                label: 'Entrega',
                                badge: 'info',
                                icon: 'fa-upload'
                            },
                            'festivo': {
                                label: 'Festivo',
                                badge: 'success',
                                icon: 'fa-calendar-day'
                            },
                            'otro': {
                                label: 'Otro',
                                badge: 'secondary',
                                icon: 'fa-bookmark'
                            }
                        };

                        const config = tipoConfig[e.tipo] || tipoConfig['otro'];
                        const fechaFormateada = new Date(e.fecha + 'T00:00:00').toLocaleDateString('es-CO', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });

                        calendarioBody.innerHTML += `
                    <tr>
                        <td>
                            <i class="far fa-calendar-alt text-muted"></i>
                            <strong>${fechaFormateada}</strong>
                        </td>
                        <td>${e.evento}</td>
                        <td>
                            <span class="badge badge-${config.badge}">
                                <i class="fas ${config.icon}"></i> ${config.label}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm btn-danger" 
                                    onclick="removeEvento(${i})"
                                    title="Eliminar evento">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    });
                }

                hiddenCalendario.value = JSON.stringify(eventos);
            }

            window.removeEvento = function(index) {
                if (confirm('¿Estás seguro de eliminar este evento?')) {
                    eventos.splice(index, 1);
                    renderEventos();
                }
            }
        </script>
        {{-- POLÍTICAS --}}
        <script>
            // 1. Inicializar con datos de la BD
            let politicas = @json(
                $curso->politicas->map(function ($p) {
                        return [
                            'titulo' => $p->titulo_politica,
                            'contenido' => $p->contenido,
                        ];
                    })->values());

            console.log('Políticas iniciales:', politicas); // DEBUG

            const listaPoliticas = document.getElementById('lista_politicas');
            const hiddenPoliticas = document.getElementById('politicas_json');

            // 2. Renderizar al cargar la página
            renderPoliticas();

            // 3. Agregar nueva política
            document.getElementById('add_politica').addEventListener('click', () => {
                const titulo = document.getElementById('politica_titulo').value.trim();
                const contenido = document.getElementById('politica_contenido').value.trim();

                console.log('Capturando:', {
                    titulo,
                    contenido
                }); // DEBUG

                if (!titulo || !contenido) {
                    alert('Completa título y contenido');
                    return;
                }

                politicas.push({
                    titulo,
                    contenido
                });
                console.log('Array después de agregar:', politicas); // DEBUG
                renderPoliticas();

                // Limpiar inputs
                document.getElementById('politica_titulo').value = '';
                document.getElementById('politica_contenido').value = '';
            });

            // 4. Función para renderizar
            function renderPoliticas() {
                listaPoliticas.innerHTML = '';

                if (politicas.length === 0) {
                    listaPoliticas.innerHTML =
                        '<li class="list-group-item text-muted text-center">No hay políticas registradas</li>';
                } else {
                    politicas.forEach((p, i) => {
                        listaPoliticas.innerHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <strong>${p.titulo}</strong>
                            <p class="mb-1">${p.contenido}</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removePolitica(${i})">✖</button>
                    </li>
                `;
                    });
                }

                // Actualizar input hidden
                hiddenPoliticas.value = JSON.stringify(politicas);
            }

            // 5. Función para eliminar
            window.removePolitica = function(index) {
                politicas.splice(index, 1);
                renderPoliticas();
            }

            // 6. Asegurar actualización antes del submit
            document.getElementById('form_curso').addEventListener('submit', function(e) {
                hiddenPoliticas.value = JSON.stringify(politicas);
            });
        </script>

    @stop
