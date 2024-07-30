<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id', 'comuna_id', 'tipo_registro_id', 'tipo_usuario', 'tipo_beneficio', 'nombre', 'descripcion', 'requisitos', 'imagen', 'vigencia'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }

    public function tipoRegistro()
    {
        return $this->belongsTo(TipoRegistro::class, 'tipo_registro_id');
    }

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class, 'beneficio_etapa', 'beneficio_id', 'etapa_id');
    }

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class);
    }
}
