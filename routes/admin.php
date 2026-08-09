<?php

use App\Http\Controllers\Academico\Profesor\TareaController; 
use App\Http\Controllers\Academico\Profesor\CalificacionController;
use App\Http\Controllers\Academico\CursoController;

use App\Http\Controllers\Academico\InscripcionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\SecretariaController;
use Illuminate\Support\Facades\Route;

// Route::get("/", [HomeController::class, "index"])->name("home")->middleware('can:home');
// RUTAS TOGGLE ACTIVATE / DEACTIVATE
Route::patch('/estudiantes/{id}/toggle-status', [EstudianteController::class, 'toggleStatus'])->name('estudiantes.toggleStatus');
Route::patch('/programador/{id}/toggle-status', [SecretariaController::class, 'toggleStatus'])->name('secretarias.toggleStatus');
Route::patch('/profesor/{id}/toggle-status', [ProfesorController::class, 'toggleStatus'])->name('profesors.toggleStatus');
Route::patch('/curso/{id}/toggle-status', [CursoController::class, 'toggleStatus'])->name('cursos.toggleStatus');

// RUTAS ADMIN

// RUTAS HOME
Route::get('/admin', [HomeController::class, 'index'])->name('index')->middleware('auth');

// RUTAS CONFIGURACIONES
Route::resource('/config', ConfigController::class)->names('config');
/* CONFIG PROFILE  * */
Route::get('/user/profile', [UserProfileController::class, 'index'])->name('profile.index');
Route::put('/user/profile-information', [UserProfileController::class, 'update'])->name('user-profile-information.update');
Route::put('/user/profile-password', [UserProfileController::class, 'updatePassword'])->name('user-profile-password.updatePassword');

// RUTAS SECRETARIAS
Route::resource('/secretarias', SecretariaController::class)->names('secretarias');

// RUTAS PROFESORES (->parameters) para usar profesores en ves de profesore
Route::resource('/profesores', ProfesorController::class)->names('profesores')->parameters(['profesores' => 'profesor']);

// RUTAS CLIENTES
Route::resource('/estudiantes', EstudianteController::class)->names('estudiantes');

// RUTAS CURSOS
Route::get('/cursos/completados', [CursoController::class, 'completados'])->name('cursos.completados');
Route::get('/cursos/mi-curso', function () {
    $user = auth()->user();

    abort_if(!$user->estudiante, 404);

    $curso = $user->estudiante->cursos()->first();

    abort_if(!$curso, 404);

    return redirect()->route('admin.cursos.show', $curso->id);
})->name('mi-curso');

Route::resource('/cursos', CursoController::class)->names('cursos');

// RUTAS para profesores
Route::get('/profesor/asistencia', [AsistenciaController::class, 'index'])->name('asistencias.index');
Route::post('/asistencia/registrar', [AsistenciaController::class, 'store'])->name('asistencias.store');

// RUTAS SECRETARIAS
Route::get('/admin/secretaria/inasistencias', [AsistenciaController::class, 'show'])->name('secretarias.inasistencias');
Route::post('/admin/asistencia/habilitar/{id}', [AsistenciaController::class, 'habilitarEstudiante'])->name('asistencia.habilitar');

// RUTAS HORARIOS ADMIN
Route::resource('/admin/horarios', HorarioController::class)->names('horarios');
Route::get('/admin/horarios/curso/{id}', [HorarioController::class, 'show_datos_cursos'])->name('horarios.show_datos_cursos');
// Agregar ANTES de la ruta existente
Route::get('/admin/horarios/curso/{id}/datos', [HorarioController::class, 'show_datos_por_curso'])
    ->name('horarios.show_datos_por_curso');
    
// RUTAS HORARIOS STUDENT ver sus reservas
Route::get('/admin/horarios/show_reserva_profesores',
    [HomeController::class, 'show_reserva_profesores'])
                                                ->name('horarios.show_reserva_profesores');

// RUTAS CLASES (creación/edición/eliminación desde el listado de reservas)
Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');
Route::get('/clases/{clase}/edit', [ClaseController::class, 'edit'])->name('clases.edit');
Route::put('/clases/{clase}', [ClaseController::class, 'update'])->name('clases.update');
Route::delete('/clases/{clase}', [ClaseController::class, 'destroy'])->name('clases.destroy');
Route::get('horarios/getCurso/{id}', [HorarioController::class, 'getCursosPorProfesor'])
    ->name('horarios.getCurso');
Route::get('admin/inscripciones/get-profesores/{cursoId}', [InscripcionController::class, 'getProfesoresPorCurso'])
    ->name('inscripciones.get_profesores');
// RUTAS HORARIOS TEACHER ver quien tiene una reserva con el
Route::get('/show_reservas/{id}', [HomeController::class, 'show_reservas'])->name('show_reservas');

// ============================================
// MÓDULO DE INSCRIPCIONES
// ============================================
Route::resource('inscripciones', InscripcionController::class)->except(['show', 'edit', 'update']);

Route::prefix('inscripciones')->name('inscripciones.')->group(function () {
    Route::post('multiple', [InscripcionController::class, 'storeMultiple'])->name('store-multiple'); // Inscripción masiva
    Route::patch('{id}/estado', [InscripcionController::class, 'cambiarEstado'])->name('cambiar-estado');// inscripcion // Cambiar estado de inscripción
    Route::get('curso/{curso}', [InscripcionController::class, 'estudiantesPorCurso'])->name('estudiantes'); // Ver estudiantes de un curso
    Route::get('estudiante/{estudiante}', [InscripcionController::class, 'cursosPorEstudiante'])->name('cursos'); // Ver cursos de un estudiante
    Route::delete('{id}', [InscripcionController::class, 'destroy'])->name('destroy'); // Eliminar inscripción
});
// RUTAS para desplegar select
Route::get('/admin/profesores/evento/{cursoId}', [ProfesorController::class, 'obtenerProfesores'])->name('obtenerProfesores');
Route::get('/admin/cursos/evento/{estudianteId}', [CursoController::class, 'obtenerCursos'])->name('obtenerCursos');
Route::get('/admin/estudiantes/{estudiante}/inscripciones',[InscripcionController::class, 'cursosPorEstudiante']
)->name('admin.estudiantes.inscripciones');

// // Route::resource('/profesor/tareas', TareaController::class)->except(['destroy'])->names('admin.profesor.tareas');
// // ✅ OPCIÓN 2: Definir rutas manualmente
Route::prefix('profesor/tareas')->middleware(['auth', 'role:profesor'])->name('profesor.tareas.')->group(function () {
    Route::get('/', [TareaController::class, 'index'])->name('index');           // GET  /profesor/tareas
    Route::get('/create', [TareaController::class, 'create'])->name('create');   // GET  /profesor/tareas/create
    Route::post('/', [TareaController::class, 'store'])->name('store');          // POST /profesor/tareas
    Route::get('/{tarea}', [TareaController::class, 'show'])->name('show');      // GET  /profesor/tareas/{id}
    Route::get('/{tarea}/edit', [TareaController::class, 'edit'])->name('edit'); // GET  /profesor/tareas/{id}/edit
    Route::put('/{tarea}', [TareaController::class, 'update'])->name('update');  // PUT  /profesor/tareas/{id}
    Route::delete('/{tarea}', [TareaController::class, 'destroy'])->name('destroy'); 
});

Route::get('profesor/calificaciones/visual', function () {
    return view('profesor.calificaciones.visual');})->name('profesor.calificaciones.visual');

// Rutas para PROFESORES - Calificaciones
Route::prefix('profesor/calificaciones')->middleware(['auth', 'role:profesor'])->name('profesor.calificaciones.')->group(function () {
    Route::get('/', [CalificacionController::class, 'index'])->name('index');                                                           // Ver todas las calificaciones de sus cursos
    // Route::get('/curso/{curso}', [CalificacionController::class, 'porCurso'])->name('por-curso');                                       // Ver calificaciones de un curso específico
    // Route::get('/estudiante/{estudiante}/curso/{curso}', [CalificacionController::class, 'porEstudiante'])->name('por-estudiante');     // Ver calificaciones de un estudiante en un curso
    Route::get('/create', [CalificacionController::class, 'create'])->name('create'); 
    Route::post('/registrar', [CalificacionController::class, 'store'])->name('store'); 
    Route::get('/{entrega}/revision', [CalificacionController::class, 'revision'])->name('revision');                                                // Crear/actualizar calificación
    // Route::get('/{calificacion}/editar', [CalificacionController::class, 'edit'])->name('edit');
    // Route::put('/{calificacion}', [CalificacionController::class, 'update'])->name('update');

    // Route::post('/masiva', [CalificacionController::class, 'storeMasiva'])->name('store-masiva');                                       // Calificar múltiples estudiantes a la vez
    // Route::patch('/{calificacion}/publicar', [CalificacionController::class, 'publicar'])->name('publicar');                            // Publicar/Ocultar calificaciones para estudiantes
    // Route::get('/exportar/curso/{curso}', [CalificacionController::class, 'exportar'])->name('exportar');                               // Exportar calificaciones
    // Route::get('/estadisticas/curso/{curso}', [CalificacionController::class, 'estadisticas'])->name('estadisticas');                   // Estadísticas de calificaciones por curso
});

Route::middleware('auth')->group(function () {
    // PERMISIONS ROUTE
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::resource('roles', RoleController::class)->names('roles'); // ROLES ROUTES

    Route::resource('/users', UserController::class)->names('users'); // USERS ROUTES
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'    ])->name('users.toggleStatus');
});



// //RUTAS REPORTES PROFESORES ADMIN
// /*NO INCLUDO */
// Route::get('/profesores/pdf/{id}', [ProfesorController::class, 'reportes'])->name('profesores.pdf');
// /*NO INCLUDO */
// Route::get('/profesores/reportes', [ProfesorController::class, 'reportes'])->name('profesores.reportes')->middleware('auth', 'can:profesores.reportes');

// //RUTAS para las reservas
// /*NO INCLUDO */
// Route::get('/reservas/reportes', [ClaseController::class, 'reportes'])->name('reservas.reportes')->middleware('auth', 'can:reservas.reportes');
// /*NO INCLUDO */
// Route::get('/reservas/pdf/{id}', [ClaseController::class, 'pdf'])->name('reservas.pdf')->middleware('auth', 'can:reservas.pdf');
// /*NO INCLUDO */
// Route::get('/reservas/pdf_fechas', [ClaseController::class, 'pdf_fechas'])->name('reservas.pdf_fechas')->middleware('auth', 'can:event.pdf_fechas');
