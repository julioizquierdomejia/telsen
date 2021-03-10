<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'ot_id',
        'area_id',
        'user_id',
        'enabled',
    ];

    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
