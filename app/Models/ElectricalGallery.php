<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalGallery extends Model
{
    use HasFactory;

    protected $table = 'electrical_gallery';

    protected $fillable = [
    	'el_id',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
