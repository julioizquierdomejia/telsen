<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'section',
        'action',
        'feedback',
        'ip',
        'device',
        'system'
    ];
}
