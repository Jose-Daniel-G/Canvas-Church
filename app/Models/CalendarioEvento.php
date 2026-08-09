<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarioEvento extends Model
{
    protected $fillable = [
        'curso_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'titulo',
        'descripcion',
        'tipo',
        'color',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}