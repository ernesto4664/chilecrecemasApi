<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioFamiliar extends Model
{
    use HasFactory;

    protected $table = 'usuario_familiars';

    protected $fillable = [
        'usuarioP_id',
        'nombres',
        'apellidos',
        'edad_id',
        'sexo',
        'fecha_nacimiento',
        'semanas_embarazo_id',
        'parentesco',
        'tipo_registro'
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioP::class, 'usuarioP_id');
    }

    public function edad()
    {
        return $this->belongsTo(EdadFamiliar::class, 'edad_id');
    }

    public function semanasEmbarazo()
    {
        return $this->belongsTo(SemanasEmbarazo::class, 'semanas_embarazo_id');
    }
}
