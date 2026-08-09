<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'clase_id',
        'estudiante_id',
        'estado',
        'hora_registro',
        'observaciones',
    ];

    protected $casts = [
        'hora_registro' => 'datetime',
    ];

    // Relaciones
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Scopes
    public function scopePresentes($query)
    {
        return $query->where('estado', 'presente');
    }

    public function scopeAusentes($query)
    {
        return $query->where('estado', 'ausente');
    }

    public function scopeTardanzas($query)
    {
        return $query->where('estado', 'tardanza');
    }
}