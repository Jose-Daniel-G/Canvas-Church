<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Estudiante extends Model
{
    use HasRoles, HasFactory;

    protected $table = "estudiantes";

    protected $guard_name = 'web';
    // protected $guarded = ['created_at', 'updated_at'];
    protected $fillable = ['nombres', 'apellidos', 'cc', 'genero', 'telefono', 'email', 'direccion', 'contacto_emergencia', 'observaciones', 'user_id',];


    public function user()
    {
        return $this->belongsTo(User::class);
    }  // Estudiante pertenece a un Usuario
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'estudiante_curso')
            ->withPivot('fecha_inscripcion', 'horas_realizadas', 'estado');
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'estudiante_id');
    }
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'estudiante_id');
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'clase_estudiante')
            ->withTimestamps();
    }
    public function entregas()
    {
        // Un estudiante tiene muchas entregas (una por cada tarea del curso)
        return $this->hasMany(Entrega::class, 'estudiante_id');
    }
    public function cursosEnProgreso()
    {
        return $this->cursos()
            ->whereColumn('estudiante_curso.horas_realizadas', '<', 'cursos.horas_requeridas');
    }
    public function cursosCompletados()
    {
        return $this->cursos()
            ->whereColumn('estudiante_curso.horas_realizadas', '>=', 'cursos.horas_requeridas');
    }
    // Calcular porcentaje de asistencia
    public function porcentajeAsistencia($cursoId = null)
    {
        $query = $this->asistencias();

        if ($cursoId) {
            $query->whereHas('clase', function ($q) use ($cursoId) {
                $q->where('curso_id', $cursoId);
            });
        }

        $total = $query->count();
        $presentes = $query->where('estado', 'presente')->count();

        return $total > 0 ? round(($presentes / $total) * 100, 2) : 0;
    }
    /* =====================
     | ACCESOR
     ===================== */

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }
}
