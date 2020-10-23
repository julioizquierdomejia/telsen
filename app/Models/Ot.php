<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Ot extends Model
{
    use HasFactory;

    public function clientes(){
    	return $this->hasOne(Client::class);
    }
}
