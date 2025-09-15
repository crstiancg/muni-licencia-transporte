<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $with = ['user'];
    protected $fillable = [
        'nombre_conductor',
        'ruta',
        'placa',
        'empresa',
        'codigo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
