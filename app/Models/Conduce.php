<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conduce extends Model
{
    use HasFactory;

    protected $table = 'conduces';
    protected $fillable = [
        'entidad_id',
        'user_id',
        'nro_conduce',
        'nro_factura',
        'fecha_modelo',
        'fecha_recepcion_transportador',
        'fecha_entrega',
        'fecha_recepcion',
        'persona_entrega',
        'persona_recpecion',
        'persona_actualiza',
        'persona_contabiliza',
        'transportador',
        'lugar_entrega',
        'comprador',
    ];
}
