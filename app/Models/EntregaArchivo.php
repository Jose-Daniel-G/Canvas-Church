<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaArchivo extends Model
{
    use HasFactory;

    protected $table = 'entrega_archivos';

    protected $fillable = [
        'entrega_id',
        'nombre',
        'ruta',
    ];

    /* ================= RELACIONES ================= */

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
