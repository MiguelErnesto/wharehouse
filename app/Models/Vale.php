<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    use HasFactory;

    protected $table = 'vales';
    protected $fillable = [
        'entidad_id',
        'almacen_id',
        'user_id',
        'tipo_vale',
        'nro_vale',
        'importe_total',
        'persona_emisor',
        'persona_receptor',
    ];
}
