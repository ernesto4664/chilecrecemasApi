<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionNoticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'notificacion_id', 
        'noticia_id', 
        'comuna_id'
    ];
}
