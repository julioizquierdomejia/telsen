<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
    	'ot_id',
        'solped',
        'recepcionado_por',
        'potencia',
        'conex',
        'mod',
        'voltaje',
        'nro_salida',
        'tipo',
        'amperaje',
        'rodla',
        'nro_equipo',
        'velocidad',
        'rodloa',
        'frame',
        'frecuencia',
        'lub',
        'fs',
        'encl',
        'cos_o',
        'aisl_clase',
        'ef',
        'cod',
        'diseno_nema',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
