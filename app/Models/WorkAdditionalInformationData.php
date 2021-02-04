<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkAdditionalInformationData extends Model
{
    use HasFactory;

    protected $table = 'work_additional_information_data';

    protected $fillable = [
        'col_id',
        'ot_work_id',
        'content',
        'row',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
