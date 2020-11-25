<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'rdi_id',
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
