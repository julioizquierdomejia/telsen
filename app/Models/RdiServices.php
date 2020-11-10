<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'rdi_id',
        'name',
        'subtotal',
        'enabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
