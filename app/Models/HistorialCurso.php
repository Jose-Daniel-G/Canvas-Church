<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCurso extends Model
{
    use HasFactory;
    protected $fillable = ['estudiante_id', 'curso_id', 'fecha_completado'];

    public function estudiante() { return $this->belongsTo(Estudiante::class); } // Uno a muchos inversa

    public function curso() {   return $this->belongsTo(Curso::class);   } // Uno a muchos inversa
}
