<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'fk_beneficio',
        'region_id',
        'comuna_id',
        'tipo_establecimiento',
        'nombre_establecimiento',
        'direccion',
        'horarios',
        'contacto',
        'lat',
        'long',
        'id_establecimiento',
    ];

    public function beneficios()
    {
        return $this->belongsToMany(Beneficio::class, 'beneficio_ubicacion', 'ubicacion_id', 'beneficio_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }

    public function baseEstablecimiento()
    {
        return $this->belongsTo(BaseEstablecimiento::class, 'id_establecimiento');
    }
}
