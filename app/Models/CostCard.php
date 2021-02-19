<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'ot_id',
        'hecho_por',
        'cost',
        'cost_m1',
        'cost_m2',
        'cost_m3',
        'enabled',
    ];
    
    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
