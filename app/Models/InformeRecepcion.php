<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeRecepcion extends Model
{
    use HasFactory;

    protected $table = 'informes_recepcion';
    protected $fillable = ['nro_informe', 'user_id', 'fecha', 'almacen_id'];
}
