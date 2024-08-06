<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_usuario', 'tipo_registro_id', 'tipo_beneficio', 'nombre', 'descripcion', 'requisitos', 'imagen', 'vigencia'
    ];

    public function regiones()
    {
        return $this->belongsToMany(Region::class, 'beneficio_region', 'beneficio_id', 'region_id');
    }

    public function comunas()
    {
        return $this->belongsToMany(Comuna::class, 'beneficio_comuna', 'beneficio_id', 'comuna_id');
    }

    public function tipoRegistro()
    {
        return $this->belongsTo(TipoDeRegistro::class, 'tipo_registro_id');
    }

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class, 'beneficio_etapa', 'beneficio_id', 'etapa_id');
    }

    public function ubicaciones()
    {
        return $this->belongsToMany(Ubicacion::class, 'beneficio_ubicacion', 'beneficio_id', 'ubicacion_id');
    }
}