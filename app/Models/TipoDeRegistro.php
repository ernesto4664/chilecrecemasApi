<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeRegistro extends Model
{
    use HasFactory;

    protected $table = 'tipos_de_registro';

    protected $fillable = ['nombre'];
}