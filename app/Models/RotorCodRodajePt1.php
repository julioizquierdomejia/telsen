<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotorCodRodajePt1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asiento_rodaje',
        'alojamiento_rodaje',
        'enabled'
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
