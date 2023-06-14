<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'direccion'];

    const MODEL_PLURAL = 'almacenes';
    const MODEL_SINGULAR_DISPLAY = 'almacen';
    protected $viewsDir = self::MODEL_PLURAL;
    protected $routePrefix = self::MODEL_PLURAL;
}
