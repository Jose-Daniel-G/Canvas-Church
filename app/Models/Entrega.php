<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'tarea_id',
        'estudiante_id',
        'comentario',
        'archivo',
        'fecha_entrega',
        'entrega_tardia',
        'estado',
    ];

    /* ================= RELACIONES ================= */

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function archivos()
    {
        return $this->hasMany(EntregaArchivo::class);
    }
    public function documentosTarea()
    {
        return $this->hasMany(TareaDocumento::class);
    }
}
