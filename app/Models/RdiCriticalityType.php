<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiCriticalityType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'enabled',

    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
