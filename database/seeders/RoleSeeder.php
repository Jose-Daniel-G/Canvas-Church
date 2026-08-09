<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // ----------------------------------------------------------------------------------------------
        // Crear roles y asignar permisos
        $superAdmin = Role::create(['name' => 'superAdmin']);
        $admin = Role::create(['name' => 'admin']);
        $secretaria = Role::create(['name' => 'secretaria']);
        $profesor = Role::create(['name' => 'profesor']);
        $estudiante = Role::create(['name' => 'estudiante']);
        $root = Role::create(['name' => 'root']);
        
        // ----------------------------------------------------------------------------------------------
        // ADMIN ROUTES

        // CONFIG
        Permission::create(['name' => 'admin.users.index', 'description' => 'Ver listado de usuarios del sistema'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.users.create', 'description' => 'Crear usuarios del sistema'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.users.edit', 'description' => 'Editar usuarios del sistema (incluye asignar roles y cambiar contraseña)'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.users.destroy', 'description' => 'Activar/desactivar usuarios del sistema'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.config.index', 'description' => 'Ver configuraciones del sistema'])->syncRoles([$root, $superAdmin]);
        Permission::create(['name' => 'admin.config.create', 'description' => 'Crear nuevas configuraciones'])->syncRoles([$root, $superAdmin]);
        Permission::create(['name' => 'admin.config.store', 'description' => 'Guardar configuraciones'])->syncRoles([$root, $superAdmin]);
        Permission::create(['name' => 'admin.config.show', 'description' => 'Ver detalles de configuración'])->syncRoles([$root, $superAdmin]);
        Permission::create(['name' => 'admin.config.edit', 'description' => 'Editar configuraciones'])->syncRoles([$root, $superAdmin]);
        Permission::create(['name' => 'admin.config.destroy', 'description' => 'Eliminar configuraciones'])->syncRoles([$root, $superAdmin]);

        // SECRETARY / PROGRAMER - CRUD
        Permission::create(['name' => 'admin.secretarias.index', 'description' => 'Ver listado de secretarias'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.secretarias.create', 'description' => 'Crear secretarias'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.secretarias.store', 'description' => 'Guardar secretarias'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.secretarias.show', 'description' => 'Ver detalles de secretarias'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.secretarias.edit', 'description' => 'Editar secretarias'])->syncRoles([$root, $superAdmin, $admin]);

        // STUDENTS - CRUD
        Permission::create(['name' => 'admin.estudiantes.index', 'description' => 'Ver listado de estudiantes'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.estudiantes.create', 'description' => 'Crear estudiantes'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.estudiantes.store', 'description' => 'Guardar estudiantes'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.estudiantes.show', 'description' => 'Ver detalles de estudiantes'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.estudiantes.edit', 'description' => 'Editar estudiantes'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        
        // COURSES - CRUD
        Permission::create(['name' => 'admin.cursos.index', 'description' => 'Ver listado de cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria, $profesor]);
        Permission::create(['name' => 'admin.cursos.create', 'description' => 'Crear cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.cursos.store', 'description' => 'Guardar cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.cursos.show', 'description' => 'Ver detalles de cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.cursos.edit', 'description' => 'Editar cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.cursos.destroy', 'description' => 'Eliminar cursos'])->syncRoles([$root, $superAdmin, $admin, $secretaria, $profesor]);
        
        // TEACHERS - CRUD
        Permission::create(['name' => 'admin.profesores.index', 'description' => 'Ver listado de profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.create', 'description' => 'Crear profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.store', 'description' => 'Guardar profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.show', 'description' => 'Ver detalles de profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.edit', 'description' => 'Editar profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.pdf', 'description' => 'Generar PDF de profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.profesores.reportes', 'description' => 'Ver reportes de profesores'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);

        // SCHEDULE - ASSIGN TEACHERS - CRUD
        Permission::create(['name' => 'admin.horarios.index', 'description' => 'Ver listado de horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.create', 'description' => 'Acceder a formulario de horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.store', 'description' => 'Guardar horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.show', 'description' => 'Ver detalles de horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.edit', 'description' => 'Editar horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.update', 'description' => 'Actualizar horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.horarios.destroy', 'description' => 'Eliminar horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'show_datos_cursos', 'description' => 'Ver datos de cursos en horarios'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        
        // PERMISOS GRANULARES PARA HORARIOS
        Permission::create(['name' => 'admin.horarios.crear_nuevos', 'description' => 'Puede crear horarios completamente nuevos en cualquier día'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.horarios.modificar_existentes', 'description' => 'Solo puede modificar horarios ya existentes (cambiar curso o ajustar horas)'])->syncRoles([$secretaria]);
        Permission::create(['name' => 'admin.horarios.agendar_dia_libre', 'description' => 'Puede agendar en días sin horarios previos (espacios libres)'])->syncRoles([$root, $superAdmin, $admin]);

        // PERMISOS CLASES
        Permission::create(['name' => 'admin.clases.create', 'description' => 'Crear clases'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.clases.edit', 'description' => 'Editar clases'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.clases.destroy', 'description' => 'Eliminar clases'])->syncRoles([$root, $superAdmin, $admin]);
        Permission::create(['name' => 'admin.acciones.seleccionCursos', 'description' => 'Puede asignar múltiples cursos al mismo horario'])->syncRoles([$root]);
        
        // ASSISTANCE - RU
        Permission::create(['name' => 'admin.asistencias.index', 'description' => 'Ver asistencias'])->syncRoles([$root, $superAdmin, $admin, $secretaria, $profesor]);
        Permission::create(['name' => 'admin.asistencias.inasistencias', 'description' => 'Ver inasistencias'])->syncRoles([$root, $superAdmin, $admin, $secretaria]);
        
        // PERMISSIONS - CRUD
        Permission::create(['name' => 'permissions.index', 'description' => 'Ver listado de permisos'])->syncRoles([$root]);
        Permission::create(['name' => 'permissions.create', 'description' => 'Crear permisos'])->syncRoles([$root]);
        Permission::create(['name' => 'permissions.edit', 'description' => 'Editar permisos'])->syncRoles([$root]);
        Permission::create(['name' => 'permissions.delete', 'description' => 'Eliminar permisos'])->syncRoles([$root]);
        
        // ROLES - CRUD
        Permission::create(['name' => 'roles.index', 'description' => 'Ver listado de roles'])->syncRoles([$root]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear roles'])->syncRoles([$root]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar roles'])->syncRoles([$root]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar roles'])->syncRoles([$root]);
        
        // ----------------------------------------------------------------------------------------
        // ------------------------ PROFESOR - TAREAS ----------------------------------------------
        Permission::create(['name' => 'admin.profesor.tareas.index', 'description' => 'Ver listado de tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.create', 'description' => 'Crear tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.store', 'description' => 'Guardar tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.show', 'description' => 'Ver detalles de tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.edit', 'description' => 'Editar tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.update', 'description' => 'Actualizar tareas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'admin.profesor.tareas.destroy', 'description' => 'Eliminar tareas'])->syncRoles([$profesor]);
        
        // ------------------------ ESTUDIANTE - TAREAS --------------------------------------------
        Permission::create(['name' => 'estudiante.cursos.index', 'description' => 'Ver tareas asignadas'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.cursos.store', 'description' => 'Entregar tareas'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.cursos.show', 'description' => 'Ver detalles de tarea'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.cursos.update', 'description' => 'Actualizar entrega'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.cursos.destroy', 'description' => 'Eliminar entrega'])->syncRoles([$estudiante]);
        
        // ------------------------ PROFESOR - ENTREGAS --------------------------------------------
        Permission::create(['name' => 'profesor.entregas.index', 'description' => 'Ver entregas de estudiantes'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.entregas.show', 'description' => 'Ver detalle de entrega'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.entregas.calificar', 'description' => 'Calificar entregas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.entregas.comentar', 'description' => 'Comentar entregas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.entregas.update', 'description' => 'Actualizar evaluación'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.entregas.descargar', 'description' => 'Descargar archivos de entrega'])->syncRoles([$profesor]);
        
        // ------------------------ INSCRIPCIONES --------------------------------------------------
        Permission::create(['name' => 'admin.inscripciones.index', 'description' => 'Ver inscripciones'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.inscripciones.create', 'description' => 'Crear inscripciones'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.inscripciones.store', 'description' => 'Guardar inscripción'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.inscripciones.store-multiple', 'description' => 'Inscripción masiva'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.inscripciones.cambiar-estado', 'description' => 'Cambiar estado de inscripción'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.inscripciones.destroy', 'description' => 'Eliminar inscripción'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'admin.inscripciones.estudiantes', 'description' => 'Ver estudiantes inscritos'])->syncRoles([$superAdmin, $admin, $secretaria, $profesor]);
        Permission::create(['name' => 'admin.inscripciones.cursos', 'description' => 'Ver cursos disponibles'])->syncRoles([$superAdmin, $admin, $secretaria]);
        
        // ------------------------ REPORTES -------------------------------------------------------
        Permission::create(['name' => 'admin.reportes.index', 'description' => 'Ver reportes generales'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.reportes.academicos', 'description' => 'Ver reportes académicos'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.reportes.exportar', 'description' => 'Exportar reportes'])->syncRoles([$superAdmin, $admin]);

        // ------------------------ REPORTES PROFESOR ----------------------------------------------
        Permission::create(['name' => 'profesor.reportes.cursos', 'description' => 'Ver reportes de cursos'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.reportes.asistencias', 'description' => 'Ver reportes de asistencias'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.reportes.tareas', 'description' => 'Ver reportes de tareas'])->syncRoles([$profesor]);

        // ------------------------ ESTADISTICAS ADMIN ---------------------------------------------
        Permission::create(['name' => 'admin.reportes.estudiantes', 'description' => 'Ver estadísticas de estudiantes'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.estudiantes.estadisticas', 'description' => 'Ver estadísticas académicas'])->syncRoles([$superAdmin, $admin, $profesor]);
        
        // ------------------------ ESTADISTICAS ESTUDIANTE ----------------------------------------
        Permission::create(['name' => 'estudiante.estadisticas.index', 'description' => 'Ver mis estadísticas'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.estadisticas.asistencias', 'description' => 'Ver mis asistencias'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.estadisticas.cursos', 'description' => 'Ver mis cursos'])->syncRoles([$estudiante]);
        
        // ------------------------ PROFESOR - CALIFICACIONES --------------------------------------
        Permission::create(['name' => 'profesor.calificaciones.index', 'description' => 'Ver calificaciones'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.por-curso', 'description' => 'Ver calificaciones por curso'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.por-estudiante', 'description' => 'Ver calificaciones por estudiante'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.store', 'description' => 'Registrar calificación'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.update', 'description' => 'Actualizar calificación'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.store-masiva', 'description' => 'Registrar calificaciones masivas'])->syncRoles([$profesor]);
        Permission::create(['name' => 'profesor.calificaciones.exportar', 'description' => 'Exportar calificaciones'])->syncRoles([$profesor]);

        // ------------------------ ESTUDIANTE - CALIFICACIONES ------------------------------------
        Permission::create(['name' => 'estudiante.calificaciones.index', 'description' => 'Ver mis calificaciones'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.calificaciones.curso', 'description' => 'Ver calificaciones por curso'])->syncRoles([$estudiante]);
        Permission::create(['name' => 'estudiante.calificaciones.historial', 'description' => 'Ver historial de calificaciones'])->syncRoles([$estudiante]);

        // ------------------------ ADMIN - CALIFICACIONES -----------------------------------------
        Permission::create(['name' => 'admin.calificaciones.index', 'description' => 'Ver todas las calificaciones'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.calificaciones.curso', 'description' => 'Ver calificaciones por curso'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.calificaciones.estudiante', 'description' => 'Ver calificaciones por estudiante'])->syncRoles([$superAdmin, $admin, $secretaria]);
        Permission::create(['name' => 'admin.calificaciones.reportes', 'description' => 'Generar reportes de calificaciones'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.calificaciones.estadisticas', 'description' => 'Ver estadísticas de calificaciones'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.calificaciones.exportar', 'description' => 'Exportar calificaciones'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.calificaciones.update', 'description' => 'Modificar calificaciones'])->syncRoles([$superAdmin, $admin]);
        Permission::create(['name' => 'admin.calificaciones.destroy', 'description' => 'Eliminar calificaciones'])->syncRoles([$superAdmin]);
        
        // ------------------------ ROOT - DELETE --------------------------------------------------
        Permission::create(['name' => 'admin.roles.index', 'description' => 'Gestionar roles'])->syncRoles([$root]);
        Permission::create(['name' => 'admin.permissions.index', 'description' => 'Gestionar permisos'])->syncRoles([$root]);
        Permission::create(['name' => 'admin.profesores.destroy', 'description' => 'Eliminar profesores (peligroso)'])->syncRoles([$root]);
        Permission::create(['name' => 'admin.secretarias.destroy', 'description' => 'Eliminar secretarias (peligroso)'])->syncRoles([$root]);
        Permission::create(['name' => 'admin.estudiantes.destroy', 'description' => 'Eliminar estudiantes (peligroso)'])->syncRoles([$root]);
        
        // ------------------------ ACCIONES ESPECIALES --------------------------------------------
        Permission::create(['name' => 'admin.acciones.insMasiva', 'description' => 'Realizar inscripciones masivas'])->syncRoles([$root, $superAdmin]);
;
    }
}
