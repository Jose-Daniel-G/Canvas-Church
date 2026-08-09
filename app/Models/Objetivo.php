<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    use HasFactory;
        protected $fillable = [
        'curso_id',
        'tipo',
        'descripcion_obj'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
