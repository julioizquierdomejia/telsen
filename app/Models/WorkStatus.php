<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkStatus extends Model
{
    use HasFactory;

    protected $table = "work_status";

    protected $fillable = [
        'code',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
