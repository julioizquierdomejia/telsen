<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdiMaintenanceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'enabled',

    ];

    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
