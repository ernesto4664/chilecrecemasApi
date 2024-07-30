<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficio_id', 'region_id', 'comuna_id', 'tipo_establecimiento', 'nombre_establecimiento', 'direccion', 'horarios', 'contacto', 'lat', 'long', 'id_establecimiento'
    ];

    public function beneficio()
    {
        return $this->belongsTo(Beneficio::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }
}

