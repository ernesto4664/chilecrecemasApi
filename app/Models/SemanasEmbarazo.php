<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemanasEmbarazo extends Model
{
    use HasFactory;

    protected $table = 'semanas_embarazos';

    protected $fillable = [
        'semana',
    ];

    public function familiares()
    {
        return $this->hasMany(UsuarioFamiliar::class, 'semanas_embarazo_id');
    }
}
