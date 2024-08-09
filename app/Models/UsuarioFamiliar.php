<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'tipoderegistro_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioP::class, 'usuarioP_id');
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }

    public function region()
    {
        return $this->comuna->region();
    }

    public function edad()
    {
        return $this->belongsTo(EdadFamiliar::class, 'edad_id');
    }

    public function semanasEmbarazo()
    {
        return $this->belongsTo(SemanasEmbarazo::class, 'semanas_embarazo_id');
    }

    public function tipoDeRegistro()
    {
        return $this->belongsTo(TipoDeRegistro::class, 'tipoderegistro_id');
    }

    public function etapa()
    {
        return $this->belongsTo(Etapa::class);
    }

    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return Carbon::parse($this->fecha_nacimiento)->age;
        }
        return null;
    }

    public function getEtapaAttribute()
    {
        if ($this->tipoDeRegistro->nombre === 'gestante' || $this->tipoDeRegistro->nombre === 'Pgestante') {
            return Etapa::where('tipo_registro_id', $this->tipoderegistro_id)
                ->where('semanas_embarazo_minima', '<=', $this->semanasEmbarazo->semana)
                ->where('semanas_embarazo_maxima', '>=', $this->semanasEmbarazo->semana)
                ->first();
        } elseif ($this->tipoDeRegistro->nombre === 'nino') {
            return Etapa::where('tipo_registro_id', $this->tipoderegistro_id)
                ->where('edad_minima', '<=', $this->edad)
                ->where('edad_maxima', '>=', $this->edad)
                ->first();
        }
        return null;
    }

    public function beneficios()
    {
        return $this->hasMany(Beneficio::class, 'tipo_registro_id', 'tipoderegistro_id');
    }
}