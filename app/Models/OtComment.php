<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class OtComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ot_id',
        'user_id',
        'comment',

    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
