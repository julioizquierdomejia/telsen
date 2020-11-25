<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotorCodRodajePt2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asiento_rodaje',
        'alojamiento_rodaje',
        'enabled'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
