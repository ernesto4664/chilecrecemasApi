<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    use HasFactory;

    protected $table = 'comunas';

    protected $fillable = [
        'nombre',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'comuna_id');
    }

    public function beneficios()
    {
        return $this->belongsToMany(Beneficio::class, 'beneficio_comuna', 'comuna_id', 'beneficio_id');
    }
}
