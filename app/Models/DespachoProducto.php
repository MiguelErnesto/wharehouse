<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespachoProducto extends Model
{
    use HasFactory;

    protected $table = 'despacho_productos';
    protected $fillable = [
        'producto_id',
        'orden_despacho_id',
        'cantidad_ordenada',
        'cantidad_despachada',
        'cantidad_entregada',
    ];
}
