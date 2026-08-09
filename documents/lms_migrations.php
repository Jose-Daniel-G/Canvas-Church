<?php

// ============================================
// 1. USUARIOS Y ROLES
// ============================================
//Basándome en tu aplicación tipo LMS (Learning Management System) similar a Canvas/Moodle

// database/migrations/2024_01_01_000000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->enum('role', ['admin', 'profesor', 'estudiante', 'secretaria'])->default('estudiante');
    $table->boolean('activo')->default(true);
    $table->rememberToken();
    $table->timestamps();
    
    // Índices
    $table->index('email');
    $table->index('role');
});

// ============================================
// 2. PERFILES
// ============================================

// database/migrations/2024_01_02_000000_create_profesores_table.php
Schema::create('profesores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
    $table->string('nombres', 100);
    $table->string('apellidos', 100);
    $table->string('documento', 20)->unique();
    $table->string('telefono', 20)->nullable();
    $table->string('direccion', 200)->nullable();
    $table->text('especialidad')->nullable();
    $table->text('biografia')->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index('user_id');
    $table->index('documento');
});

// database/migrations/2024_01_03_000000_create_estudiantes_table.php
Schema::create('estudiantes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
    $table->string('nombres', 100);
    $table->string('apellidos', 100);
    $table->string('documento', 20)->unique();
    $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
    $table->string('celular', 20)->nullable();
    $table->string('direccion', 200)->nullable();
    $table->string('contacto_emergencia', 20)->nullable();
    $table->string('nombre_contacto_emergencia', 100)->nullable();
    $table->text('observaciones')->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index('user_id');
    $table->index('documento');
});

// database/migrations/2024_01_04_000000_create_secretarias_table.php
Schema::create('secretarias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
    $table->string('nombres', 100);
    $table->string('apellidos', 100);
    $table->string('documento', 20)->unique();
    $table->string('celular', 20)->nullable();
    $table->date('fecha_nacimiento')->nullable();
    $table->string('direccion', 200)->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index('user_id');
    $table->index('documento');
});

// ============================================
// 3. CURSOS Y CONTENIDO ACADÉMICO
// ============================================

// database/migrations/2024_01_05_000000_create_cursos_table.php
Schema::create('cursos', function (Blueprint $table) {
    $table->id();
    
    // Información básica
    $table->string('codigo', 50)->unique();
    $table->string('nombre', 255);
    $table->text('descripcion')->nullable();
    
    // Configuración académica
    $table->string('periodo', 50); // ej: 2026-1
    $table->integer('creditos')->default(0);
    $table->integer('horas_requeridas')->default(0);
    
    // Evaluación
    $table->enum('escala_calificacion', ['0-5', '0-100'])->default('0-5');
    $table->decimal('nota_minima_aprobacion', 4, 2)->default(3.0);
    
    // Estado del curso
    $table->boolean('activo')->default(true);
    $table->boolean('visible_estudiantes')->default(true);
    $table->boolean('cerrado')->default(false); // cierre académico
    
    // Fechas importantes
    $table->date('fecha_inicio')->nullable();
    $table->date('fecha_fin')->nullable();
    
    $table->timestamps();
    $table->softDeletes(); // Para no perder historial
    
    // Índices
    $table->index('codigo');
    $table->index('periodo');
    $table->index('activo');
});

// database/migrations/2024_01_06_000000_create_objetivos_table.php
Schema::create('objetivos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->enum('tipo', ['general', 'especifico', 'cognitivo', 'procedimental', 'actitudinal']);
    $table->text('descripcion');
    $table->integer('orden')->default(0);
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'tipo']);
});

// database/migrations/2024_01_07_000000_create_bibliografias_table.php
Schema::create('bibliografias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->string('autor', 255)->nullable();
    $table->enum('tipo', ['libro', 'articulo', 'web', 'video', 'pdf', 'otro'])->default('libro');
    $table->string('editorial', 200)->nullable();
    $table->string('anio', 4)->nullable();
    $table->string('isbn', 20)->nullable();
    $table->text('url')->nullable();
    $table->integer('orden')->default(0);
    
    $table->timestamps();
    
    // Índices
    $table->index('curso_id');
});

// database/migrations/2024_01_08_000000_create_calendario_eventos_table.php
Schema::create('calendario_eventos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->date('fecha');
    $table->time('hora_inicio')->nullable();
    $table->time('hora_fin')->nullable();
    $table->string('titulo', 255);
    $table->text('descripcion')->nullable();
    $table->enum('tipo', ['clase', 'evaluacion', 'examen', 'taller', 'parcial', 'entrega', 'festivo', 'otro'])->default('clase');
    $table->string('color', 7)->default('#3490dc'); // Color hexadecimal
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'fecha']);
    $table->index('tipo');
});

// database/migrations/2024_01_09_000000_create_documentos_table.php
Schema::create('documentos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->text('descripcion')->nullable();
    $table->string('archivo'); // ruta en storage
    $table->string('nombre_original'); // nombre del archivo original
    $table->string('tipo_mime', 100); // application/pdf, etc
    $table->string('extension', 10); // pdf, docx, etc
    $table->bigInteger('tamanio')->default(0); // en bytes
    $table->integer('descargas')->default(0);
    $table->boolean('visible')->default(true);
    
    $table->timestamps();
    
    // Índices
    $table->index('curso_id');
    $table->index('visible');
});

// database/migrations/2024_01_10_000000_create_politicas_table.php
Schema::create('politicas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->text('descripcion');
    $table->integer('orden')->default(0);
    
    $table->timestamps();
    
    // Índices
    $table->index('curso_id');
});

// ============================================
// 4. RELACIONES CURSO-PROFESOR-ESTUDIANTE
// ============================================

// database/migrations/2024_01_11_000000_create_horarios_table.php
Schema::create('horarios', function (Blueprint $table) {
    $table->id();
    
    $table->enum('dia', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
    $table->time('hora_inicio');
    $table->time('hora_fin');
    $table->string('aula', 50)->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index('dia');
});

// database/migrations/2024_01_12_000000_create_curso_profesor_table.php
Schema::create('curso_profesor', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
    $table->foreignId('horario_id')->nullable()->constrained('horarios')->onDelete('set null');
    
    $table->enum('rol', ['titular', 'auxiliar', 'monitor'])->default('titular');
    $table->boolean('activo')->default(true);
    
    $table->timestamps();
    
    // Índices y restricciones
    $table->unique(['curso_id', 'profesor_id', 'horario_id']);
    $table->index('curso_id');
    $table->index('profesor_id');
});

// database/migrations/2024_01_13_000000_create_curso_estudiante_table.php
Schema::create('curso_estudiante', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
    
    $table->integer('horas_realizadas')->default(0);
    $table->decimal('nota_final', 5, 2)->nullable();
    $table->enum('estado', ['activo', 'retirado', 'aprobado', 'reprobado'])->default('activo');
    $table->date('fecha_inscripcion')->nullable();
    $table->date('fecha_retiro')->nullable();
    
    $table->timestamps();
    
    // Índices y restricciones
    $table->unique(['curso_id', 'estudiante_id']);
    $table->index('curso_id');
    $table->index('estudiante_id');
    $table->index('estado');
});

// ============================================
// 5. CLASES Y ASISTENCIA
// ============================================

// database/migrations/2024_01_14_000000_create_clases_table.php
Schema::create('clases', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->text('descripcion')->nullable();
    $table->dateTime('fecha_hora_inicio');
    $table->dateTime('fecha_hora_fin');
    $table->string('aula', 50)->nullable();
    $table->string('color', 7)->default('#3490dc');
    
    $table->enum('estado', ['programada', 'en_curso', 'finalizada', 'cancelada'])->default('programada');
    $table->text('motivo_cancelacion')->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'fecha_hora_inicio']);
    $table->index('profesor_id');
    $table->index('estado');
});

// database/migrations/2024_01_15_000000_create_asistencias_table.php
Schema::create('asistencias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('clase_id')->constrained('clases')->onDelete('cascade');
    $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
    
    $table->enum('estado', ['presente', 'ausente', 'tardanza', 'excusado'])->default('ausente');
    $table->time('hora_registro')->nullable();
    $table->text('observaciones')->nullable();
    
    $table->timestamps();
    
    // Índices y restricciones
    $table->unique(['clase_id', 'estudiante_id']);
    $table->index('clase_id');
    $table->index('estudiante_id');
    $table->index('estado');
});

// ============================================
// 6. TAREAS Y EVALUACIONES
// ============================================

// database/migrations/2024_01_16_000000_create_tareas_table.php
Schema::create('tareas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->text('descripcion')->nullable();
    $table->text('instrucciones')->nullable();
    
    $table->dateTime('fecha_apertura')->nullable();
    $table->dateTime('fecha_cierre');
    $table->decimal('puntaje_maximo', 5, 2)->default(5.0);
    $table->decimal('porcentaje_nota_final', 5, 2)->default(0); // % que vale en la nota final
    
    $table->enum('tipo', ['tarea', 'quiz', 'examen', 'proyecto', 'foro', 'otro'])->default('tarea');
    $table->boolean('permite_entregas_tardias')->default(false);
    $table->decimal('penalizacion_tardia', 5, 2)->default(0); // Puntos a descontar
    $table->boolean('visible')->default(true);
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'fecha_cierre']);
    $table->index('tipo');
});

// database/migrations/2024_01_17_000000_create_entregas_table.php
Schema::create('entregas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tarea_id')->constrained('tareas')->onDelete('cascade');
    $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
    
    $table->text('comentario_estudiante')->nullable();
    $table->string('archivo')->nullable();
    $table->string('nombre_archivo')->nullable();
    $table->dateTime('fecha_entrega');
    $table->boolean('entrega_tardia')->default(false);
    
    $table->decimal('nota', 5, 2)->nullable();
    $table->text('retroalimentacion')->nullable();
    $table->dateTime('fecha_calificacion')->nullable();
    $table->foreignId('calificado_por')->nullable()->constrained('profesores')->onDelete('set null');
    
    $table->enum('estado', ['pendiente', 'calificada', 'devuelta'])->default('pendiente');
    
    $table->timestamps();
    
    // Índices y restricciones
    $table->unique(['tarea_id', 'estudiante_id']);
    $table->index('tarea_id');
    $table->index('estudiante_id');
    $table->index('estado');
});

// ============================================
// 7. ANUNCIOS Y COMUNICACIÓN
// ============================================

// database/migrations/2024_01_18_000000_create_anuncios_table.php
Schema::create('anuncios', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
    
    $table->string('titulo', 255);
    $table->text('contenido');
    $table->boolean('importante')->default(false);
    $table->dateTime('fecha_publicacion')->nullable();
    $table->boolean('visible')->default(true);
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'fecha_publicacion']);
    $table->index('importante');
});

// ============================================
// 8. CONFIGURACIÓN GENERAL
// ============================================

// database/migrations/2024_01_19_000000_create_configuracion_table.php
Schema::create('configuracion', function (Blueprint $table) {
    $table->id();
    
    $table->string('nombre_institucion', 255);
    $table->text('descripcion')->nullable();
    $table->string('direccion', 255)->nullable();
    $table->string('telefono', 20)->nullable();
    $table->string('email', 100)->nullable();
    $table->string('sitio_web', 255)->nullable();
    
    $table->string('logo')->nullable();
    $table->string('favicon')->nullable();
    
    $table->string('color_primario', 7)->default('#3490dc');
    $table->string('color_secundario', 7)->default('#6574cd');
    
    $table->timestamps();
});

// ============================================
// 9. HISTORIAL Y AUDITORÍA
// ============================================

// database/migrations/2024_01_20_000000_create_historial_cursos_table.php
Schema::create('historial_cursos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
    $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
    
    $table->string('periodo', 50);
    $table->decimal('nota_final', 5, 2)->nullable();
    $table->enum('estado', ['aprobado', 'reprobado', 'retirado'])->default('aprobado');
    $table->text('observaciones')->nullable();
    
    $table->timestamps();
    
    // Índices
    $table->index(['curso_id', 'estudiante_id']);
    $table->index('periodo');
});