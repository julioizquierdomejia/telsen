<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtGallery extends Model
{
    use HasFactory;

    protected $table = 'ot_gallery';

    protected $fillable = [
        'ot_id',
    	'eval_type',
        'file',
        'name',
        'work_id',
        'enabled',
    ];
    protected $casts = [
        //'enabled' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
