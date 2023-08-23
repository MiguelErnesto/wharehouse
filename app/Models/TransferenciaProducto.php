<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferenciaProducto extends Model
{
    use HasFactory;

    protected $table = 'transferencia_productos';
    protected $fillable = [
        'transferencia_id',
        'producto_id',
        'cantidad_remitida',
        'cantidad_recibida',
    ];
}
