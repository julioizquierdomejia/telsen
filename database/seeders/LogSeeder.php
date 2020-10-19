<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $log = new Log();
        $log->user_id = 1;
        $log->section = 'Usuarios';
        $log->action = 'Creación';
        $log->feedback = 'self';
        $log->ip = '$getip';
        $log->device = '$getdevice';
        $log->system = '$getos';
        $log->save();
    }
}
