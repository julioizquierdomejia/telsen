<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkAdditionalInformationCol extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'col_name',
        'col_type',
        'service_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
