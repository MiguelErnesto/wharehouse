<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $fillable = [
        'user_id',
        'entidad_id',
        'nro_factura',
        'fecha_modelo',
        'fecha_entrega',
        'fecha_recepcion',
        'fecha_recepcion_transportador',
        'importe_total',
        'porciento',
        'datos_registro',
        'operaciones',
        'moneda_pago',
        'persona_contabiliza',
        'persona_entrega',
        'persona_recibe',
        'transportista',
        'persona_transportador',
    ];
}
