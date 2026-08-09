<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'periodo',
        'horas_requeridas',
    ]; 
    public function objetivos()
    {
        return $this->hasMany(Objetivo::class);
    }

    public function bibliografias()
    {
        return $this->hasMany(Bibliografia::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function politicas()
    {
        return $this->hasMany(Politica::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
    public function calendarioEventos()
    {
        return $this->hasMany(CalendarioEvento::class);
    }
    /* =========================
    * RELACIONES EXISTENTES
    * ========================= */
    public function clases()                // Uno a muchos
    {
        return $this->hasMany(Clase::class);
    }

    public function horarioProfesorCurso() // Uno a muchos
    {
        return $this->hasMany(HorarioProfesorCurso::class, 'curso_id');
    }

    public function profesores()            // Uno a muchos inversa En el modelo Profesor
    {
        return $this->belongsToMany(Profesor::class, 'horario_profesor_curso', 'curso_id', 'profesor_id');
    }

    public function horarios()              // Muchos a muchos con horarios
    {
        return $this->belongsToMany(Horario::class, 'horario_profesor_curso', 'curso_id', 'horario_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_curso', 'curso_id', 'estudiante_id')
        ->withPivot('horas_realizadas', 'fecha_inscripcion')
        ->withTimestamps();
    }
}
// public function historialCursos()
// {
//     return $this->hasMany(HistorialCurso::class);
// }
/* =========================
* NUEVAS RELACIONES Q10
 * ========================= */

// // 📚 Contenido académico
// public function contenidos()
// {
//     return $this->hasMany(ContenidoCurso::class);
// }

// // 📝 Actividades / Tareas
// public function tareas()
// {
//     return $this->hasMany(Tarea::class);
// }

// // 📢 Anuncios
// public function anuncios()
// {
//     return $this->hasMany(AnuncioCurso::class);
// }

// // 🕒 Asistencias
// public function asistencias()
// {
//     return $this->hasMany(Asistencia::class);
// }
