<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificacions';

    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'profesor_id',
        'entrega_id',
        'concepto',
        'nota',
        'nota_maxima',
        'porcentaje',
        'tipo_evaluacion',
        'periodo',
        'fecha_calificacion',
        'observaciones',
        'publicada',
    ];

    protected $casts = [
        'nota' => 'decimal:2',
        'nota_maxima' => 'decimal:2',
        'porcentaje' => 'integer',
        'fecha_calificacion' => 'date',
        'publicada' => 'boolean',
    ];

    // ========================================
    // RELACIONES
    // ========================================

    /**
     * Relación con Estudiante
     */
public function estudiante()
{
    // Asegúrate de que la llave foránea sea 'estudiante_id'
    return $this->belongsTo(Estudiante::class, 'estudiante_id');
}

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'entrega_id');
    }

    // ========================================
    // SCOPES
    // ========================================

    /**  Scope: Solo calificaciones publicadas */
    public function scopePublicadas($query)
    {
        return $query->where('publicada', true);
    }

    /**  Scope: Calificaciones de un período específico */
    public function scopePorPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    /**  Scope: Calificaciones por tipo de evaluación */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_evaluacion', $tipo);
    }

    /**  Scope: Calificaciones de un curso */  
    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    /**  Scope: Calificaciones de un estudiante */
    public function scopePorEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    // ========================================
    // MÉTODOS AUXILIARES
    // ========================================

    /**  Obtener la nota en porcentaje  */
    public function getNotaPorcentajeAttribute()
    {
        if ($this->nota_maxima == 0) {
            return 0;
        }
        return round(($this->nota / $this->nota_maxima) * 100, 2);
    }

    /** Calcular el aporte de esta calificación a la nota final */
    public function getAporteNotaFinalAttribute()
    {
        return round(($this->nota / $this->nota_maxima) * ($this->porcentaje / 100) * $this->nota_maxima, 2);
    }

    /**
     * Verificar si el estudiante aprobó esta evaluación
     */
    public function aprobo($notaMinima = 3.0)
    {
        return $this->nota >= $notaMinima;
    }

    /**
     * Obtener el estado de la calificación (Aprobado/Reprobado)
     */
    public function getEstadoAttribute()
    {
        $notaMinima = 3.0; // Puedes hacerlo configurable
        return $this->nota >= $notaMinima ? 'Aprobado' : 'Reprobado';
    }

    /**
     * Obtener el color para mostrar la calificación
     */
    public function getColorAttribute()
    {
        $porcentaje = $this->nota_porcentaje;

        if ($porcentaje >= 90) return 'success'; // Verde
        if ($porcentaje >= 70) return 'info';    // Azul
        if ($porcentaje >= 60) return 'warning'; // Amarillo
        return 'danger'; // Rojo
    }

    // ========================================
    // MÉTODOS ESTÁTICOS
    // ========================================

    /**
     * Calcular promedio de calificaciones de un estudiante en un curso
     */
    public static function promedioEstudianteCurso($estudianteId, $cursoId)
    {
        return self::where('estudiante_id', $estudianteId)
            ->where('curso_id', $cursoId)
            ->where('publicada', true)
            ->avg('nota');
    }

    /**
     * Calcular promedio ponderado de un estudiante en un curso
     */
    public static function promedioPonderadoEstudianteCurso($estudianteId, $cursoId)
    {
        $calificaciones = self::where('estudiante_id', $estudianteId)
            ->where('curso_id', $cursoId)
            ->where('publicada', true)
            ->get();

        if ($calificaciones->isEmpty()) {
            return 0;
        }

        $sumaPonderada = 0;
        $sumaPorcentajes = 0;

        foreach ($calificaciones as $calif) {
            // (nota / nota_maxima) * porcentaje
            $notaNormalizada = ($calif->nota / $calif->nota_maxima);
            $sumaPonderada += $notaNormalizada * $calif->porcentaje;
            $sumaPorcentajes += $calif->porcentaje;
        }

        if ($sumaPorcentajes == 0) {
            return 0;
        }

        // Calcular el promedio ponderado y escalarlo a la nota máxima (ej: 5.0)
        $promedioPonderado = ($sumaPonderada / $sumaPorcentajes) * 5.0;

        return round($promedioPonderado, 2);
    }

    /**
     * Obtener estadísticas de un curso
     */
    public static function estadisticasCurso($cursoId)
    {
        $calificaciones = self::where('curso_id', $cursoId)
            ->where('publicada', true)
            ->get();

        return [
            'total' => $calificaciones->count(),
            'promedio' => round($calificaciones->avg('nota'), 2),
            'nota_maxima' => $calificaciones->max('nota'),
            'nota_minima' => $calificaciones->min('nota'),
            'aprobados' => $calificaciones->filter(fn($c) => $c->nota >= 3.0)->count(),
            'reprobados' => $calificaciones->filter(fn($c) => $c->nota < 3.0)->count(),
        ];
    }
}