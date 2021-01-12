<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkAdditionalInformation extends Model
{
    use HasFactory;

    protected $table = 'work_additional_informations';

    protected $fillable = [
        'name',
        'ot_work_id',
        'public'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
