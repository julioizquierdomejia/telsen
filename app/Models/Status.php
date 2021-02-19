<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'name',
        'description',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function ots(){
        return $this->belongsToMany(Ot::class);
    }
}
