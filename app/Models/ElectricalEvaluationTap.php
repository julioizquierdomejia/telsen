<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationTap extends Model
{
    use HasFactory;

    protected $table = 'eval_electrical_tap';

    protected $fillable = [
        'uv1',
        'uv2',
        'vu1',
        'vu2',
        'wu1',
        'wu2',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
