<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationTestIn extends Model
{
    use HasFactory;

    protected $fillable = [
    	'eel_id',

        //'motor',
        'motor_aisl_m',
        'motor_nro_salidas',
        'motor_conexión',
        'motor_volt_v',
        'motor_amp_a',
        'motor_rpm',
        'motor_frec_hz',
        'er_aisl_m',
        'er_nro_salidas',
        'er_conexion',
        'er_volt_v',
        'er_amp_a',
        'er_nro_polos',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
