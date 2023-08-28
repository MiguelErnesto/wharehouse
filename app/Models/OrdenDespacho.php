<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDespacho extends Model
{
    use HasFactory;

    protected $table = 'ordenes_despacho';
    protected $fillable = [
        'entidad_id',
        'almacen_id',
        'cliente_id',
        'user_id',
        'fecha',
        'lugar_entrega',
        'fecha_entrega',
        'transferencia_id',
        'vale_id',
        'nro_orden',
        'tipo_salida',
    ];
}
