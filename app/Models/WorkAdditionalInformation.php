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
        'service_id',
        'mode',
        'public'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function cols()
    {
        return $this->hasMany(WorkAdditionalInformationCol::class, 'work_add_info_id');
    }
}
