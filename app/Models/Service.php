<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'area_id',
        'enabled'
    ];

    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function tables()
    {
        return $this->hasMany(WorkAdditionalInformation::class);
    }
}
