<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepcionProducto extends Model
{
    use HasFactory;

    protected $table = 'recepcion_productos';
    protected $fillable = ['nro_informe', 'user_id', 'fecha', 'almacen_id'];
}
