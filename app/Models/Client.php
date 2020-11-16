<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ot;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc', 'razon_social', 'direccion', 'telefono', 'celular', 'contacto','telefono_contacto','email', 'info', 'enabled',

    ];

    public function ots(){
    	return $this->hasMany(Ot::class);
    }
}
