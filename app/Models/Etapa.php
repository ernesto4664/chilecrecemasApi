<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre','etapa', 'tipo_registro_id', 'edad_minima', 'edad_maxima', 'semanas_embarazo_minima', 'semanas_embarazo_maxima'
    ];


        // Define the relationship with TipoDeRegistro
        public function tipoDeRegistro()
        {
            return $this->belongsTo(TipoDeRegistro::class, 'tipo_registro_id');
        }
}