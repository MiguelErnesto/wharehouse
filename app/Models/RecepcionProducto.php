<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionProducto extends Model
{
    use HasFactory;

    protected $table = 'recepcion_productos';
    protected $fillable = ['producto_almacen_id', 'user_id', 'fecha'];
}
