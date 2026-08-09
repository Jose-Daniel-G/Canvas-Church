@extends('adminlte::page')

@section('title', 'Crear Tarea')

@section('content_header')
    <h1>
        <i class="fas fa-plus-circle"></i> Crear Nueva Tarea
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        
        <form action="{{ route('admin.profesor.tareas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                {{-- Columna izquierda --}}
                <div class="col-md-8">
                    
                    {{-- Información Básica --}}
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Información Básica
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            {{-- Curso --}}
                            <div class="form-group">
                                <label for="curso_id">Curso <span class="text-danger">*</span></label>
                                <select name="curso_id" id="curso_id" 
                                        class="form-control @error('curso_id') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Seleccione un curso --</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->codigo }} - {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Tipo de Tarea --}}
                            <div class="form-group">
                                <label for="tipo">Tipo de Actividad <span class="text-danger">*</span></label>
                                <select name="tipo" id="tipo" 
                                        class="form-control @error('tipo') is-invalid @enderror" 
                                        required>
                                    <option value="tarea"    {{ old('tipo') == 'tarea' ? 'selected' : '' }}>Tarea</option>
                                    <option value="quiz"     {{ old('tipo') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                    <option value="examen"   {{ old('tipo') == 'examen' ? 'selected' : '' }}>Examen</option>
                                    <option value="proyecto" {{ old('tipo') == 'proyecto' ? 'selected' : '' }}>Proyecto</option>
                                    <option value="foro"     {{ old('tipo') == 'foro' ? 'selected' : '' }}>Foro</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Título --}}
                            <div class="form-group">
                                <label for="titulo_tarea">Título de la Tarea <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="titulo_tarea" 
                                       id="titulo_tarea" 
                                       class="form-control @error('titulo_tarea') is-invalid @enderror" 
                                       value="{{ old('titulo_tarea') }}"
                                       placeholder="Ej: Proyecto Integrador - Portfolio Personal"
                                       required>
                                @error('titulo_tarea')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group">
                                <label for="descripcion_tarea">Descripción <span class="text-danger">*</span></label>
                                <textarea name="descripcion_tarea" 
                                          id="descripcion_tarea" 
                                          class="form-control @error('descripcion_tarea') is-invalid @enderror" 
                                          rows="5"
                                          placeholder="Describe la tarea en detalle..."
                                          required>{{ old('descripcion_tarea') }}</textarea>
                                @error('descripcion_tarea')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Puedes usar HTML para dar formato al texto</small>
                            </div>

                        </div>
                    </div>

                    {{-- Requisitos --}}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul"></i> Requisitos y Criterios
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            {{-- Requisitos --}}
                            <div class="form-group">
                                <label for="requisitos">Requisitos (opcional)</label>
                                <textarea name="requisitos" 
                                          id="requisitos" 
                                          class="form-control" 
                                          rows="6"
                                          placeholder="Lista los requisitos que debe cumplir la tarea...&#10;&#10;Ejemplo:&#10;- Estructura HTML5 semántica&#10;- Diseño responsive&#10;- Código limpio y comentado">{{ old('requisitos') }}</textarea>
                                <small class="text-muted">Un requisito por línea</small>
                            </div>

                            {{-- Criterios de Evaluación --}}
                            <div class="form-group">
                                <label for="criterios_evaluacion">Criterios de Evaluación (opcional)</label>
                                <textarea name="criterios_evaluacion" 
                                          id="criterios_evaluacion" 
                                          class="form-control" 
                                          rows="6"
                                          placeholder="Define cómo se evaluará la tarea...&#10;&#10;Ejemplo:&#10;Estructura HTML: 20 pts&#10;Diseño responsive: 25 pts&#10;Funcionalidad: 20 pts">{{ old('criterios_evaluacion') }}</textarea>
                            </div>

                        </div>
                    </div>

                    {{-- Documentos de Apoyo --}}
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">
                                <i class="fas fa-paperclip"></i> Recursos de Apoyo
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="documentos">Subir Archivos (opcional)</label>
                                <div class="custom-file">
                                    <input type="file" 
                                           name="documentos[]" 
                                           id="documentos" 
                                           class="custom-file-input" 
                                           multiple
                                           accept=".pdf,.doc,.docx,.zip,.rar">
                                    <label class="custom-file-label" for="documentos">Seleccionar archivos...</label>
                                </div>
                                <small class="text-muted">
                                    Puedes subir guías, plantillas, videos, etc. (máx. 50MB por archivo)
                                </small>
                            </div>

                            <div id="preview-documentos"></div>

                        </div>
                    </div>

                </div>

                {{-- Columna derecha --}}
                <div class="col-md-4">
                    
                    {{-- Configuración de Fechas --}}
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt"></i> Fechas
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            {{-- Fecha de Apertura --}}
                            <div class="form-group">
                                <label for="fecha_apertura">Fecha de Apertura</label>
                                <input type="datetime-local" 
                                       name="fecha_apertura" 
                                       id="fecha_apertura" 
                                       class="form-control" 
                                       value="{{ old('fecha_apertura') }}">
                                <small class="text-muted">Dejar vacío para que esté disponible inmediatamente</small>
                            </div>

                            {{-- Fecha de Entrega --}}
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha Límite <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="fecha_entrega" 
                                       id="fecha_entrega" 
                                       class="form-control @error('fecha_entrega') is-invalid @enderror" 
                                       value="{{ old('fecha_entrega') }}"
                                       required>
                                @error('fecha_entrega')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Configuración de Calificación --}}
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-star"></i> Calificación
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            {{-- Puntaje --}}
                            <div class="form-group">
                                <label for="puntaje">Puntaje Máximo <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="puntaje" 
                                       id="puntaje" 
                                       class="form-control @error('puntaje') is-invalid @enderror" 
                                       value="{{ old('puntaje', 100) }}"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       required>
                                @error('puntaje')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Escala 0-100</small>
                            </div>

                            {{-- Permitir Entregas Tardías --}}
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="permite_entregas_tardias" 
                                           name="permite_entregas_tardias"
                                           {{ old('permite_entregas_tardias') ? 'checked' : '' }}
                                           onchange="togglePenalizacion()">
                                    <label class="custom-control-label" for="permite_entregas_tardias">
                                        Permitir entregas tardías
                                    </label>
                                </div>
                            </div>

                            {{-- Penalización --}}
                            <div class="form-group" id="div_penalizacion" style="display: none;">
                                <label for="penalizacion_tardia">Penalización (puntos)</label>
                                <input type="number" 
                                       name="penalizacion_tardia" 
                                       id="penalizacion_tardia" 
                                       class="form-control" 
                                       value="{{ old('penalizacion_tardia', 0) }}"
                                       min="0"
                                       step="0.01">
                                <small class="text-muted">Puntos a descontar por entrega tardía</small>
                            </div>

                        </div>
                    </div>

                    {{-- Configuración de Entrega --}}
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                <i class="fas fa-upload"></i> Formato de Entrega
                            </h3>
                        </div>
                        <div class="card-body">
                            
                            {{-- Formato de Entrega --}}
                            <div class="form-group">
                                <label for="formato_entrega">Tipo de Entrega <span class="text-danger">*</span></label>
                                <select name="formato_entrega" 
                                        id="formato_entrega" 
                                        class="form-control" 
                                        required
                                        onchange="toggleFormatoConfig()">
                                    <option value="archivo" {{ old('formato_entrega') == 'archivo' ? 'selected' : '' }}>Solo archivos</option>
                                    <option value="enlace" {{ old('formato_entrega') == 'enlace' ? 'selected' : '' }}>Solo enlace (URL)</option>
                                    <option value="texto" {{ old('formato_entrega') == 'texto' ? 'selected' : '' }}>Solo texto</option>
                                    <option value="ambos" {{ old('formato_entrega') == 'ambos' ? 'selected' : '' }}>Archivos y enlace</option>
                                </select>
                            </div>

                            {{-- Formatos Aceptados --}}
                            <!-- <div class="form-group" id="div_formatos">
                                <label for="formatos_aceptados">Formatos Aceptados</label>
                                <input type="text" 
                                       name="formatos_aceptados" 
                                       id="formatos_aceptados" 
                                       class="form-control" 
                                       value="{{ old('formatos_aceptados', '.zip,.rar,.pdf') }}"
                                       placeholder=".zip,.pdf,.docx">
                                <small class="text-muted">Separados por comas</small>
                            </div> -->

                            {{-- Tamaño Máximo --}}
                            <!-- <div class="form-group" id="div_tamanio">
                                <label for="tamanio_maximo">Tamaño Máximo (MB)</label>
                                <input type="number" 
                                       name="tamanio_maximo" 
                                       id="tamanio_maximo" 
                                       class="form-control" 
                                       value="{{ old('tamanio_maximo', 50) }}"
                                       min="1">
                            </div> -->

                            {{-- Intentos Permitidos --}}
                            <!-- <div class="form-group">
                                <label for="intentos_permitidos">Intentos Permitidos <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="intentos_permitidos" 
                                       id="intentos_permitidos" 
                                       class="form-control" 
                                       value="{{ old('intentos_permitidos', 1) }}"
                                       min="1"
                                       required>
                                <small class="text-muted">Número de veces que puede entregar</small>
                            </div> -->

                        </div>
                    </div>

                    {{-- Visibilidad --}}
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">
                                <i class="fas fa-eye"></i> Visibilidad
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="visible" 
                                       name="visible"
                                       {{ old('visible', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="visible">
                                    Visible para estudiantes</label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Si está desactivado, solo tú podrás ver la tarea
                            </small>
                        </div>
                    </div></div>
        </div>

        {{-- Botones de Acción --}}
        <div class="card">
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Crear Tarea
                </button>
                <a href="{{ route('admin.profesor.tareas.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>

    </form>

</div>
@stop
@section('css')
<style>
.custom-file-label::after {
content: "Buscar";
}
</style>
@stop
@section('js')
<script>
// Preview de archivos seleccionados
document.getElementById('documentos').addEventListener('change', function(e) {
const preview = document.getElementById('preview-documentos');
preview.innerHTML = '';
if (this.files.length > 0) {
            preview.innerHTML = '<strong>Archivos seleccionados:</strong><ul class="mt-2">';
            for (let i = 0; i < this.files.length; i++) {
                preview.innerHTML += `<li>${this.files[i].name} (${(this.files[i].size / 1024 / 1024).toFixed(2)} MB)</li>`;
            }
            preview.innerHTML += '</ul>';
        }
    });

    // Actualizar label del input file
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files.length > 1 
            ? `${e.target.files.length} archivos seleccionados` 
            : e.target.files[0]?.name || 'Seleccionar archivos...';
        
        e.target.nextElementSibling.innerText = fileName;
    });

    // Toggle penalización
    function togglePenalizacion() {
        const checkbox = document.getElementById('permite_entregas_tardias');
        const div = document.getElementById('div_penalizacion');
        div.style.display = checkbox.checked ? 'block' : 'none';
    }

    // Toggle configuración de formato
    function toggleFormatoConfig() {
        const select = document.getElementById('formato_entrega');
        const divFormatos = document.getElementById('div_formatos');
        const divTamanio = document.getElementById('div_tamanio');
        
        if (select.value === 'archivo' || select.value === 'ambos') {
            divFormatos.style.display = 'block';
            divTamanio.style.display = 'block';
        } else {
            divFormatos.style.display = 'none';
            divTamanio.style.display = 'none';
        }
    }

    // Ejecutar al cargar
    document.addEventListener('DOMContentLoaded', function() {
        togglePenalizacion();
        toggleFormatoConfig();
    });
</script>
@stop
<!-- ---

## 🛣️ **4. RUTAS**
```php
// routes/admin.php o routes/web.php

Route::middleware(['auth', 'role:profesor'])->prefix('profesor')->name('profesor.')->group(function () {
    
    // Tareas
    Route::resource('tareas', TareaProfesorController::class);
    
    // Eliminar documento de tarea
    Route::delete('tareas/documentos/{documento}', [TareaProfesorController::class, 'eliminarDocumento'])
        ->name('tareas.documentos.destroy');
});
```

---

**¿Necesitas que cree la vista de detalle de tarea (show) o el formulario de edición?** -->