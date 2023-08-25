<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConduceProducto extends Model
{
    use HasFactory;

    protected $table = 'conduce_productos';
    protected $fillable = ['producto_id', 'conduce_id', 'cantidad'];
}
