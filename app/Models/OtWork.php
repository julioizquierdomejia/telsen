<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'ot_id',
        'service_id',
        'type',
        'description',
        'medidas',
        'qty',
        'personal',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function work_logs()
    {
        return $this->hasMany(WorkLog::class, 'work_id')->orderBy('id');
    }
}
