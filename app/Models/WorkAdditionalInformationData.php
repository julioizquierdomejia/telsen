<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkAdditionalInformationData extends Model
{
    use HasFactory;

    protected $fillable = [
        'col_id',
        'ot_work_id',
        'content',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
