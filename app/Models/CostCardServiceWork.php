<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCardServiceWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'cc_id',
        'service_id',
        'description',
        'medidas',
        'qty',
        'personal',
    ];

    protected $date = [
    	'created_at',
    	'updated_at'
    ];
}
