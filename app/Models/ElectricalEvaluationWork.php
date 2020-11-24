<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalEvaluationWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'me_id',
        'service_id',
        'description',
        'medidas',
        'qty',
        'personal',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
