<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiServiceCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'rdi_id',
        'rdi_service_id',
        'subtotal',
        'enabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
