<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticia';

    protected $primaryKey = 'idnoticia';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'fecha_hora',
        'status',
        'privilegio',
        'tags_idtags',
        'usuariop_id',
    ];

    // Relación con la tabla `tags`
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tags_idtags', 'idtags');
    }

    // Relación con la tabla `user_admins`
    public function userAdmin()
    {
        return $this->belongsTo(UserAdmin::class, 'usuariop_id', 'id');
    }
}
