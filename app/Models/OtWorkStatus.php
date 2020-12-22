<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtWorkStatus extends Model
{
    use HasFactory;

    protected $table = 'ot_work_status';

    protected $fillable = [
        'work_status_id',
        'ot_work_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
