<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdadFamiliar extends Model
{
    use HasFactory;

    protected $table = 'edad_familiars';

    protected $fillable = [
        'edad',
    ];
}
