<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Rdi extends Model
{
    use HasFactory;

    protected $table = 'rdi';

    protected $fillable = [
        'rdi_codigo',
        'version',
        'contact',
        'area',
        'equipo',
        'codigo',
        'ot_id',
        'marca_id',

        'nro_serie',
        'frame',
        'potencia',
        'tension',
        'corriente',
        'velocidad',
        'conexion',
        'deflexion_eje',
        'rodaje_delantero',
        'rodaje_posterior',
        'antecedentes',

        'hecho_por',
        'cost',

        'diagnostico_actual',

        'aislamiento_masa_ingreso',
        'rdi_maintenance_type_id',
        'rdi_criticality_type_id',

        'enabled',

    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'fecha_ingreso',
        'orden_servicio',

        'created_at',
        'updated_at'
    ];

    public function marca()
    {
        return $this->belongsTo('App\Models\MotorBrand', 'marca_id');
    }
    public function modelo()
    {
        return $this->belongsTo('App\Models\MotorModel', 'modelo_id');
    }

    public function clientes() {
    	return $this->hasOne(Client::class);
    }
}
