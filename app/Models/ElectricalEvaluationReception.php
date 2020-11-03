<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationReception extends Model
{
    use HasFactory;

    protected $fillable = [
    	'eel_id',

        'placa_caract_orig',
        'escudos',
        'ventilador',
        'caja_conexion',
        'ejes',
        'acople',
        'bornera',
        'funda',
        'chaveta',
        'otros',
        'detalles',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
