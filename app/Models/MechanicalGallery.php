<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalGallery extends Model
{
    use HasFactory;

    protected $table = 'mechanical_gallery';

    protected $fillable = [
    	'me_id',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
