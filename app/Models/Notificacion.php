<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'gestion_de_notificaciones';

    protected $fillable = [
        'tipo_notificacion',
        'contenido_id',
        'target_audience',
        'scheduled_time',
        'status',
        'nombre',
        'descripcion',
        'archivo',
        'url',
        'fecha_creacion',
        'region_id',
        'comuna_id',
    ];

    // Relación con las regiones
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Relación con las comunas
    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }

    // Si tipo_notificacion es "noticia", obtener la noticia asociada
    public function noticia()
    {
        return $this->belongsTo(Noticia::class, 'contenido_id');
    }

    // Si tipo_notificacion es "beneficio", obtener el beneficio asociado
    public function beneficio()
    {
        return $this->belongsTo(Beneficio::class, 'contenido_id');
    }
}