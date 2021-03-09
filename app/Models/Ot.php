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
        //'fecha_creacion',
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
        'closure_comments',
        'priority',
        'enabled',

    ];

    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
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

    public function clientes(){
    	return $this->hasOne(Client::class);
    }

    public function statuses(){
        //return $this->belongsToMany(StatusOt::class);
        return $this->belongsToMany(Status::class, 'status_ot')->withPivot('ot_id')->orderBy('id', 'asc');
    }

    public function works()
    {
        return $this->hasMany(OtWork::class, 'ot_id')
            //->orderBy('id', 'desc')
            ;
    }
}
