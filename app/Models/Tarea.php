<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'curso_id',
        'titulo_tarea',
        'descripcion_tarea',
        'fecha_entrega',
        'puntaje',
        'requisitos',
        'criterios_evaluacion',
        'fecha_apertura',
        // 'permite_entregas_tardias',
        // 'penalizacion_tardia',
        // 'visible',
        // 'intentos_permitidos',
        // 'formato_entrega',
        // 'formatos_aceptados',
        // 'tamanio_maximo',
    ];
    protected $casts = [
        'fecha_entrega' => 'datetime',
        // 'fecha_apertura' => 'datetime',
        // 'permite_entregas_tardias' => 'boolean',
        // 'visible' => 'boolean',
    ];
    /* ================= RELACIONES ================= */

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function documentos()
    {
        return $this->hasMany(TareaDocumento::class);
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    //      // ================= ACCESSORS =================

    //     /**
    //      * Verificar si la tarea está abierta para entregas
    //      */
    //     public function getEstaAbiertaAttribute()
    //     {
    //         $ahora = now();

    //         if ($this->fecha_apertura && $ahora->lt($this->fecha_apertura)) {
    //             return false; // Aún no abre
    //         }

    //         if ($this->fecha_entrega && $ahora->gt($this->fecha_entrega) && !$this->permite_entregas_tardias) {
    //             return false; // Ya cerró
    //         }

    //         return true;
    //     }

    //     /**
    //      * Verificar si la entrega está retrasada
    //      */
    //     public function getEsTardiaAttribute()
    //     {
    //         if (!$this->fecha_entrega) {
    //             return false;
    //         }

    //         return now()->gt($this->fecha_entrega);
    //     }

    //     /**
    //      * Días restantes para la entrega
    //      */
    //     public function getDiasRestantesAttribute()
    //     {
    //         if (!$this->fecha_entrega) {
    //             return null;
    //         }

    //         return now()->diffInDays($this->fecha_entrega, false);
    //     }

    //     /**
    //      * Porcentaje de entregas
    //      */
    //     public function getPorcentajeEntregasAttribute()
    //     {
    //         $totalEstudiantes = $this->curso->estudiantes()->count();

    //         if ($totalEstudiantes == 0) {
    //             return 0;
    //         }

    //         $entregasRealizadas = $this->entregas()->count();

    //         return round(($entregasRealizadas / $totalEstudiantes) * 100, 2);
    //     }

    //     // ================= SCOPES =================

    //     public function scopeVisibles($query)
    //     {
    //         return $query->where('visible', true);
    //     }

    //     public function scopePorCurso($query, $cursoId)
    //     {
    //         return $query->where('curso_id', $cursoId);
    //     }

    //     public function scopeProximas($query)
    //     {
    //         return $query->where('fecha_entrega', '>=', now())
    //                      ->orderBy('fecha_entrega', 'asc');
    //     }

    //     public function scopeVencidas($query)
    //     {
    //         return $query->where('fecha_entrega', '<', now());
    //     }
}
