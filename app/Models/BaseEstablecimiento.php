<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseEstablecimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_antiguo', 'codigo_vigente', 'codigo_madre_antiguo', 'codigo_madre_nuevo', 'codigo_region'
    ];

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'id_establecimiento');
    }
}

