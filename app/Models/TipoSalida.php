<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSalida extends Model
{
    use HasFactory;

    protected $table = 'tipos_salida';
    protected $fillable = ['descripcion'];
}
