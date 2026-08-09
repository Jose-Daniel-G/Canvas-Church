<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{
    use HasFactory;
    protected $fillable = [
        'curso_id',
        'titulo',
        'autor',
        'tipo',
        'url',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
