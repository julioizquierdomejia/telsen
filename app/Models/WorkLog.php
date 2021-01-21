<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'user_id',
        'type',
        'description',
        'status_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function status()
    {
        return $this->hasOne(WorkStatus::class, 'id' ,'status_id');
    }
}
