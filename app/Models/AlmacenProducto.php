<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmacenProducto extends Model
{
    use HasFactory;

    protected $table = 'almacenes_productos';
    protected $fillable = ['almacen_id', 'producto_id', 'cantidad'];
}
