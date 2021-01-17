<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkAdditionalInformationCol extends Model
{
    use HasFactory;

    protected $table = 'work_additional_information_cols';

    protected $fillable = [
        'work_add_info_id',
        'table_id',
        'col_name',
        'col_type',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function data()
    {
        return $this->hasMany(WorkAdditionalInformationData::class, 'col_id')->orderBy('row', 'asc');
    }
}
