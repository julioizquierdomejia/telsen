<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCardService extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_card_id',
        'area_id',
        'service_id',
        'personal',
        'ingreso',
        'salida',
        'subtotal',
    ];

    protected $date = [
    	'created_at',
    	'updated_at'
    ];
}
