<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'profesor_id',
        'titulo',
        'descripcion',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'aula',
        'modalidad',
        'link_virtual',
        'estado',
        'color',
    ];

    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'fecha_hora_fin' => 'datetime',
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'clase_estudiante')
                    ->withTimestamps();
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Scopes
    public function scopeProgramadas($query)
    {
        return $query->where('estado', 'programada');
    }

    public function scopeDictadas($query)
    {
        return $query->where('estado', 'dictada');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_hora_inicio', today());
    }
}