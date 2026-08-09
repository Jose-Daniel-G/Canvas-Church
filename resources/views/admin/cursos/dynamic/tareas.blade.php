<!-- Main Content -->
<div class="main-content">
    <!-- Top Bar -->
    <div class="top-bar">
        <div>
            <h5 class="mb-0">Módulo 1: Fundamentos de la Fe</h5>
            <small class="text-muted">Lección 1.3 - La Palabra de Dios</small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="user-avatar">JP</div>
            <div>
                <div style="font-weight: 600; font-size: 14px;">Juan Pérez</div>
                <div style="font-size: 12px; color: #6b7280;">Estudiante</div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content-area">
        <!-- Video Player -->
        <div class="video-container">
            <i class="fas fa-play-circle" style="opacity: 0.3;"></i>
        </div>

        <!-- Tabs Navigation -->
        <div class="tab-nav">
            {{-- <div class="tab-item active" onclick="switchTab('overview')">
                <i class="fas fa-book-bible"></i> Resumen --}}
            </div>
            <div class="tab-item" onclick="switchTab('tasks')">
                <i class="fas fa-pencil-alt"></i> Actividades (3)
            </div>
            <div class="tab-item" onclick="switchTab('resources')">
                <i class="fas fa-scroll"></i> Recursos
            </div>
            <div class="tab-item" onclick="switchTab('discussion')">
                <i class="fas fa-comments"></i> Reflexión
            </div>
        </div>

        <!-- Overview Content -->
        {{-- @include('admin.cursos.dynamic.partials.OverviewContent') --}}

        <!-- Tasks Content -->
        <div id="tasks-content" class="tab-content" style="display: none;">
            <div class="row">
                <div class="col-lg-8">

                    <!-- Tasks List -->
                    <div id="tasks-list-view">
                        <h4 class="mb-4">Actividades del estudio</h4>

                        <div class="task-card" onclick="openTask(1)">
                            <h5>Actividad 1: Lectura Bíblica</h5>
                            <p class="text-muted">Lee 2 Timoteo 3:16-17 y escribe una reflexión personal.</p>
                            <span class="task-status completed">
                                <i class="fas fa-check"></i> Completada
                            </span>
                        </div>

                        <div class="task-card" onclick="openTask(2)">
                            <h5>Actividad 2: Análisis del Texto</h5>
                            <p class="text-muted">Identifica los beneficios de la Palabra de Dios según el pasaje.</p>
                            <span class="task-status graded">
                                <i class="fas fa-star"></i> Revisada
                            </span>
                        </div>

                        <div class="task-card border-primary" onclick="openTask(3)">
                            <h5>Actividad 3: Aplicación Práctica</h5>
                            <p class="text-muted">
                                Describe cómo puedes aplicar lo aprendido en tu vida diaria esta semana.
                            </p>
                            <span class="task-status pending">
                                <i class="fas fa-clock"></i> Pendiente
                            </span>
                        </div>
                    </div>

                    <!-- Task Detail -->
                    <div id="task-detail-view" class="task-detail-view">
                        <button class="btn btn-link" onclick="closeTask()">
                            <i class="fas fa-arrow-left"></i> Volver a actividades
                        </button>

                        <div class="content-card mt-3">
                            <h3>Actividad 3: Aplicación Práctica</h3>
                            <p class="text-muted">Reflexiona y escribe tu compromiso personal.</p>

                            <h5 class="mt-4">Instrucciones</h5>
                            <ul>
                                <li>Ora antes de responder</li>
                                <li>Lee nuevamente el pasaje bíblico</li>
                                <li>Escribe con sinceridad</li>
                                <li>Aplica el mensaje a tu contexto personal</li>
                            </ul>

                            <textarea class="form-control mt-3" rows="5"
                                placeholder="Escribe aquí tu reflexión..."></textarea>

                            <div class="d-flex gap-2 mt-4">
                                <button class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Enviar reflexión
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-save"></i> Guardar borrador
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="content-card">
                        <h5>Tu progreso espiritual</h5>
                        <div class="text-center">
                            <div style="font-size: 48px; font-weight: bold;">67%</div>
                            <div class="text-muted">Lecciones completadas</div>
                        </div>
                    </div>

                    <div class="content-card mt-3">
                        <h5>Próximas lecturas</h5>
                        <p><strong>Salmos 119:105</strong></p>
                        <small class="text-muted">La Palabra como guía</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resources Content -->
        <div id="resources-content" class="tab-content" style="display: none;">
            <div class="content-card">
                <h4>Recursos bíblicos</h4>
                <ul>
                    <li>📖 Biblia Reina-Valera 1960</li>
                    <li>📘 Guía de estudio bíblico</li>
                    <li>🎧 Devocional en audio</li>
                </ul>
            </div>
        </div>

        <!-- Discussion Content -->
        <div id="discussion-content" class="tab-content" style="display: none;">
            <div class="content-card">
                <h4>Espacio de reflexión</h4>
                <textarea class="form-control mb-2" rows="3"
                    placeholder="Comparte lo que Dios habló a tu corazón..."></textarea>
                <button class="btn btn-primary">Publicar</button>
            </div>
        </div>
    </div>
</div>
```
