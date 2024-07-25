<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeRegistro extends Model
{
    use HasFactory;

    protected $table = 'tipos_de_registro';

    protected $fillable = ['nombre'];

    // Define the inverse relationship with Etapa
    public function etapas()
    {
        return $this->hasMany(Etapa::class, 'tipo_registro_id');
    }
}