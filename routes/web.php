<?php

use App\Http\Controllers\Academico\EntregaController;
use App\Http\Controllers\Academico\Estudiante\TareaController;  
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\PerfilCompletarController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Academico\Estudiante\CalificacionController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [HomeController::class, 'show'])->name('admin.home.show');

Route::middleware('auth')->group(function () {
    Route::get('/completar-perfil', [PerfilCompletarController::class, 'show'])->name('perfil.completar');
    Route::post('/completar-perfil', [PerfilCompletarController::class, 'store'])->name('perfil.completar.store');
});

/* LANDING  * */ Route::get('/', function () {return view('auth.login'); });
/* DASHBOARD * */ Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home'); }); // ->group(function () {Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');});
/* REGISTER  * */ Route::get('/register', function () {return redirect('/'); });

// Route::get('/admin/cursos/partials', [CursoController::class, 'quemada'])->name('partials.quemada');

Route::get('/admin/cursos/contenido', function () {
    return view('admin.cursos.dynamic.contenido');
})->name('partials.contenido');

Route::resource('/estudiante/tareas', TareaController::class)->names('estudiante.tareas')->middleware(['auth', 'role:estudiante']);
Route::resource('/estudiante/entregas/', EntregaController::class)->names('estudiante.entregas')->middleware(['auth', 'role:estudiante']);
Route::resource('asistencias', AsistenciaController::class)->only(['index', 'store']);

// ============================================
// MÓDULO DE ASISTENCIAS
// ============================================
Route::prefix('asistencias')->name('asistencias.')->group(function () {
    // Excusar/Justificar inasistencia
    Route::post('{asistencia}/excusar', [AsistenciaController::class, 'excusar'])
        ->name('asistencias.excusar');

    // Registro rápido (AJAX)
    Route::post('asistencias.rapido', [AsistenciaController::class, 'registrarRapido'])
        ->name('asistencias.rapido');

    // Estadísticas de un estudiante
    Route::get('estadisticas/{estudiante}', [AsistenciaController::class, 'estadisticas'])
        ->name('asistencias.excusar');
});



// Route::get(
//     'estudiante/tareas/{tarea}',
//     [TareaController::class, 'show']
// )->name('estudiante.tareas.show');

// ============================================
// RUTAS CALIFICACIONES ESTUDIANTES
// ============================================ 
Route::prefix('estudiante/calificaciones')->middleware(['auth', 'role:estudiante'])->name('estudiante.calificaciones.')->group(function () {
    Route::get('/', [CalificacionController::class, 'index'])->name('index');              // Ver todas las calificaciones de sus cursos

    Route::get('/curso/{curso}', [CalificacionController::class, 'porCurso'])->name('por-curso');// Ver calificaciones de un curso específico

    Route::get('/estudiante/{estudiante}/curso/{curso}', [CalificacionController::class, 'porEstudiante'])
                                                    ->name('por-estudiante');              // Ver calificaciones de un estudiante en un curso
    Route::post('/registrar', [CalificacionController::class, 'store'])->name('store');    // Crear/actualizar calificación
    Route::get('/{calificacion}/editar', [CalificacionController::class, 'edit'])->name('edit');
    Route::put('/{calificacion}', [CalificacionController::class, 'update'])->name('update');

    Route::post('/masiva', [CalificacionController::class, 'storeMasiva'])->name('store-masiva');    // Calificar múltiples estudiantes a la vez
    Route::patch('/{calificacion}/publicar', [CalificacionController::class, 'publicar'])->name('publicar');    // Publicar/Ocultar calificaciones para estudiantes
    Route::get('/exportar/curso/{curso}', [CalificacionController::class, 'exportar'])->name('exportar');    // Exportar calificaciones

    Route::get('/estadisticas/curso/{curso}', [CalificacionController::class, 'estadisticas'])->name('estadisticas');    // Estadísticas de calificaciones por curso
}); 
// // ========== RUTAS ADMIN - GESTIÓN DE CALIFICACIONES ==========
// Route::prefix('admin/calificaciones')
//     ->middleware(['auth', 'role:superAdmin|admin|secretaria'])
//     ->name('admin.calificaciones.')
//     ->group(function () {
//         // Dashboard general de calificaciones
//         Route::get('/', [CalificacionController::class, 'adminIndex'])->name('index');

//         // Ver todas las calificaciones de un curso
//         Route::get('/curso/{curso}', [CalificacionController::class, 'adminPorCurso'])->name('curso');

//         // Ver todas las calificaciones de un estudiante
//         Route::get('/estudiante/{estudiante}', [CalificacionController::class, 'adminPorEstudiante'])->name('estudiante');

//         // Reportes académicos
//         Route::get('/reportes', [CalificacionController::class, 'reportes'])->name('reportes');
//         Route::get('/reportes/curso/{curso}', [CalificacionController::class, 'reporteCurso'])->name('reportes.curso');
//         Route::get('/reportes/periodo/{periodo}', [CalificacionController::class, 'reportePeriodo'])->name('reportes.periodo');

//         // Estadísticas generales
//         Route::get('/estadisticas', [CalificacionController::class, 'estadisticasGenerales'])->name('estadisticas');

//         // Exportar datos
//         Route::get('/exportar', [CalificacionController::class, 'exportarGeneral'])->name('exportar');
//         Route::get('/exportar/curso/{curso}', [CalificacionController::class, 'exportarCurso'])->name('exportar.curso');

//         // Modificar calificación (solo admin/superAdmin)
//         Route::put('/{calificacion}/editar', [CalificacionController::class, 'adminUpdate'])
//             ->name('update')
//             ->middleware('role:superAdmin|admin');

//         // Eliminar calificación (solo superAdmin)
//         Route::delete('/{calificacion}', [CalificacionController::class, 'destroy'])
//             ->name('destroy')
//             ->middleware('role:superAdmin');
//     });