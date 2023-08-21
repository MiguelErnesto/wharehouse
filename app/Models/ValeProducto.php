<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeProducto extends Model
{
    use HasFactory;

    protected $table = 'vale_productos';
    protected $fillable = ['vale_id', 'producto_id', 'cantidad'];
}
