<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TareaDocumento extends Model
{
    use HasFactory;

    protected $table = 'tarea_documentos';

    protected $fillable = [
        'tarea_id',
        'titulo',
        'archivo',
        'tipo'
    ];

    /* ================= RELACIONES ================= */

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    /* ================= ACCESSORS ================= */

    /**
     * Obtener la URL pública del archivo
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->archivo);
    }

    /**
     * Obtener el icono según el tipo de archivo
     */
    public function getIconoAttribute()
    {
        $iconos = [
            'pdf'  => 'fas fa-file-pdf text-danger',
            'doc'  => 'fas fa-file-word text-primary',
            'docx' => 'fas fa-file-word text-primary',
            'xls'  => 'fas fa-file-excel text-success',
            'xlsx' => 'fas fa-file-excel text-success',
            'ppt'  => 'fas fa-file-powerpoint text-warning',
            'pptx' => 'fas fa-file-powerpoint text-warning',
            'zip'  => 'fas fa-file-archive text-secondary',
            'rar'  => 'fas fa-file-archive text-secondary',
            'jpg'  => 'fas fa-file-image text-info',
            'jpeg' => 'fas fa-file-image text-info',
            'png'  => 'fas fa-file-image text-info',
            'gif'  => 'fas fa-file-image text-info',
            'txt'  => 'fas fa-file-alt text-muted',
        ];

        return $iconos[$this->tipo] ?? 'fas fa-file text-secondary';
    }

    /**
     * Obtener el tamaño del archivo en formato legible
     */
    public function getTamanioAttribute()
    {
        if (Storage::disk('public')->exists($this->archivo)) {
            $bytes = Storage::disk('public')->size($this->archivo);
            
            if ($bytes >= 1048576) {
                return number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                return number_format($bytes / 1024, 2) . ' KB';
            }
            
            return $bytes . ' B';
        }
        
        return 'N/A';
    }

    /* ================= MÉTODOS ================= */

    /**
     * Boot method para eliminar archivo físico al borrar el registro
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($documento) {
            // Eliminar archivo físico del storage
            if (Storage::disk('public')->exists($documento->archivo)) {
                Storage::disk('public')->delete($documento->archivo);
            }
        });
    }
}