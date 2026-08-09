<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'titulo',
        'archivo',
        'tipo',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
