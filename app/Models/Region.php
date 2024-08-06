<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
        'nombre',
    ];

    public function comunas()
    {
        return $this->hasMany(Comuna::class, 'region_id');
    }

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'region_id');
    }

    public function beneficios()
    {
        return $this->belongsToMany(Beneficio::class, 'beneficio_region', 'region_id', 'beneficio_id');
    }
}
