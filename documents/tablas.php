 <?
        // Para eventos académicos (exámenes, entregas, festivos)
        Schema::create('calendario_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['examen', 'entrega', 'parcial', 'festivo', 'otro'])->default('otro');
            $table->string('color', 7)->default('#3490dc');

            $table->timestamps();
        });
                Schema::create('entrega_archivos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('entrega_id')
                ->constrained('entregas')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('archivo');

            $table->timestamps();
        });
                Schema::create('tarea_documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained('tareas')->cascadeOnDelete();

            $table->string('titulo');
            $table->string('archivo'); // ruta en storage
            $table->string('tipo')->nullable(); // pdf, docx, etc

            $table->timestamps();
        });
                Schema::create('politicas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_politica'); // Ej: "Tareas Atrasadas"
            $table->text('contenido');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            
            $table->string('titulo_documento');
            $table->string('archivo'); // ruta en storage
            $table->string('tipo_documento')->nullable(); // pdf, docx, etc
            
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->timestamps();
        });
                Schema::create('bibliografias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('titulo'); 
            $table->string('url')->nullable();
            $table->timestamps();
        });
                Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->enum('tipo', ['general', 'especifico', 'cognitivo', 'conativo', 'afectivo']);
           $table->text('descripcion_obj');
            $table->timestamps();
        });
                Schema::create('entregas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->text('comentario')->nullable();
            $table->enum('estado', ['pendiente', 'calificada', 'tardia'])
                ->default('pendiente');
            $table->dateTime('fecha_entrega')->nullable();
            $table->boolean('entrega_tardia')->default(false);
            $table->timestamps();
        });
                Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion_tarea')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->decimal('puntaje', 5, 2)->default(100);
            $table->timestamps();
        });
                Schema::create('horario_profesor_curso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->foreignId('profesor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clase_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            // evita duplicados
            $table->unique(['estudiante_id', 'clase_id']);
        }); 
        // 1. Crear CLASES primero
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->string('color');
            $table->enum('estado', ['programada', 'dictada', 'cancelada'])
                  ->default('programada');

            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profesor_id')->constrained('profesors')->cascadeOnDelete();

            $table->timestamps();
        });

        // 2. Crear pivot CLASE_ESTUDIANTE
        Schema::create('clase_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['clase_id', 'estudiante_id']);
        }); 
                Schema::create('estudiante_curso', function (Blueprint $table) {
            $table->id();  // JD
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->integer('horas_realizadas')->default(0);
            $table->timestamp('fecha_inscripcion')->nullable();
            $table->enum('estado',['activo','retirado','aprobado','reprobado'])->default('activo');
            $table->timestamps();
        });
                Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedBigInteger('profesor_id'); 
            $table->foreign('profesor_id')->references('id')->on('profesors')->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('profesors', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono');
            // $table->string('especialidad'); //JD
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
                Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            // Información básica
            $table->string('codigo')->unique(); // ej: MAT-101
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Configuración académica
            $table->string('periodo'); // ej: 2026-1
            
            // Estado del curso JD
            $table->boolean('estado')->default(true); // activo / inactivo 
            $table->integer('horas_requeridas')->default(0); 
            
            
            // // Evaluación
            // $table->enum('escala_calificacion', ['0-5', '0-100'])->default('0-5');
            // $table->decimal('nota_minima_aprobacion', 4, 2)->default(3.0);
            $table->timestamps();
        });
                Schema::create('estudiantes', function (Blueprint $table) {
            $table->id(); // JD
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->integer('cc')->unique();
            $table->string('genero', 10);
            $table->integer('celular');
            $table->string('direccion', 150);
            $table->integer('contacto_emergencia')->nullable();
            $table->string('observaciones', 255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('secretarias', function (Blueprint $table) {
            $table->id(); // JD
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('cc')->unique();
            $table->string('celular', 100);
            $table->string('fecha_nacimiento', 100);
            $table->string('direccion', 100);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('users', function (Blueprint $table) {
            $table->id(); // JD
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            // Campo para desactivar usuario
            $table->integer('status')->default(true);
            $table->timestamps();
        });