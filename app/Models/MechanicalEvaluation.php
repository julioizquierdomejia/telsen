<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
    	//'client_id',
        'ot_id',

        'rpm',
        'hp_kw',

        'serie',
        'solped',
        'placa_caract_orig',
        'tapas',
        'ventilador',
        'caja_conexion',
        'ejes',
        'acople',
        'bornera',
        'fundas',
        'chaveta',
        'impro_seal',
        'laberintos',
        'estator',

        'slam_muelle_p1',
        'slam_muelle_p2',
        'resortes_contra_tapas',
        'alineamiento_paquete',

        'rotor_deplexion_eje',
        'rotor_valor_balanceo',
        'rotor_cod_rodaje_p1',
        'rotor_cod_rodaje_p2',
        'rotor_asiento_rodaje_p1',
        'rotor_asiento_rodaje_p2',
        'rotor_eje_zona_acople_p1',
        'rotor_eje_zona_acople_p2',
        'rotor_medida_chaveta_p1',
        'rotor_medida_chaveta_p2',

        'estator_alojamiento_rodaje_tapa_p10',
        'estator_alojamiento_rodaje_tapa_p20',
        'estator_pestana_tapa_p1',
        'estator_pestana_tapa_p2',

        'estator_contra_tapa_interna_p1',
        'estator_contra_tapa_interna_p2',
        'estator_contra_tapa_externa_p1',
        'estator_contra_tapa_externa_p2',

        'estator_ventilador_0',
        'estator_alabes',
        'estator_caja_conexion',
        'estator_tapa_conexion',

        'observaciones',

        'works',
    ];
}
