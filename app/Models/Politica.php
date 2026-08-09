<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{
    use HasFactory;
    protected $fillable = ['curso_id','titulo_politica','contenido'];

    public function curso(){
        return $this->belongsTo(Curso::class);
    }
}
