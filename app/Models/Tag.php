<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'idtags';
    public $timestamps = false; // Si tu tabla no tiene las columnas `created_at` y `updated_at`

    protected $fillable = [
        'nombre',
        'prioridad',
    ];
}