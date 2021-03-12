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
        'comments',
        'approved',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function work_logs()
    {
        return $this->hasMany(WorkLog::class, 'work_id')->orderBy('id', 'desc');
    }

    public function ot()
    {
        return $this->belongsTo(Ot::class, 'ot_id');
    }

    /*public function ot_work_status() {
        return $this->belongsToMany(WorkStatus::class, 'ot_work_status')->withPivot('ot_work_id');
    }*/
}
