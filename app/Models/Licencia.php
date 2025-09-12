<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $fillable = [
        'nombre_conductor',
        'ruta',
        'placa',
        'empresa',
        'codigo'
    ];
}
