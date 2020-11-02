<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Ot extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'fecha_creacion',
        'guia_cliente',
        //'solped',
        'descripcion_motor',
        'codigo_motor',
        'marca_id',
        'modelo_id',
        'numero_potencia',
        'medida_potencia',
        'voltaje',
        'velocidad',
        'enabled',

    ];

    public function marca()
    {
        return $this->belongsTo('App\Models\BrandMotor', 'marca_id');
    }
    public function modelo()
    {
        return $this->belongsTo('App\Models\ModelMotor', 'modelo_id');
    }

    public function clientes(){
    	return $this->hasOne(Client::class);
    }
}
