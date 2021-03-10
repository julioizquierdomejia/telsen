<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiIngreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'rdi_id',
        'placa_caracteristicas',
        'caja_conexion',
        'bornera',
        'escudos',
        'ejes',
        'funda',
        'ventilador',
        'acople',
        'chaveta',
        'enabled',
    ];

    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
