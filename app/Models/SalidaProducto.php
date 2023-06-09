<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProducto extends Model
{
    use HasFactory;

    protected $table = 'salida_productos_almacen';
    protected $fillable = [
        'producto_almacen_id',
        'tipo_salida',
        'fecha',
        'destino',
        'cantidad',
    ];
}
