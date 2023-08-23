<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'transferencias';
    protected $fillable = [
        'entidad_id',
        'almacen_origen_id',
        'almacen_destino_id',
        'user_id',
        'nro_transferencia',
        'fecha_modelo',
        'fecha_traslado',
        'fecha_recepcion',
        'persona_autoriza',
        'persona_entrega',
        'persona_recibe',
        'persona_actualiza_origen',
        'persona_actualiza_destino',
        'persona_contabiliza_origen',
        'persona_contabiliza_destino',
        'importe_total_entrega',
        'importe_total_recibido',
    ];
}
