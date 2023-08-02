<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionProducto extends Model
{
    use HasFactory;

    protected $table = 'recepcion_productos';
    protected $fillable = ['informe_recepcion_id', 'producto_id', 'cantidad'];
}
