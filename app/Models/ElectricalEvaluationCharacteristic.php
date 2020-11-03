<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationCharacteristic extends Model
{
    use HasFactory;

    protected $table = 'eval_electrical_characteristics';

    protected $fillable = [
    	'eel_id',
        'marca',
        'potencia',
        'escudos',
        'mod',
        'voltaje',
        'ejes',
        'nro',
        'amperaje',
        'funda',
        'frame',
        'velocidad',
        'acople',
        'fs',
        'encl',
        'peso',
        'frecuencia',
        'otros',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
