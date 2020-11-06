<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCard extends Model
{
    use HasFactory;

    protected $table = 'cost_card';

    protected $fillable = [
        'ot_id',
        'enabled',
    ];
}
