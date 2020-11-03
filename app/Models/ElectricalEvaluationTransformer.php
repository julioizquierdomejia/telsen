<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationTransformer extends Model
{
    use HasFactory;

    protected $fillable = [
    	'eel_id',

        'tap',
        'aisl_m',
        'nro_salidas',
        'conexion',
        'volt_v',
        'amp_a',
        'nro_polos',
        'aisl_m_at_masa',
        'st_masa',
        'et_at',
        'grupo_conex',
        'polaridad',
        'relac_transf',
        'otp',
        'tec',
        'amp',
        'rig_diel_aceite',
        'ruv',
        'rv_w',
        'rw_u',
        'ru_v',
        'rv_u',
        'ww',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
