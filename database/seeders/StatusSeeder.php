<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new Status();
        $status->name = 'OT Creada';
        $status->description = 'Creación de OT';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'Evaluación Mecánica';
        $status->description = 'Evaluación Mecánica';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'Evaluación Eléctrica';
        $status->description = 'Evaluación Eléctrica';
        $status->enabled = 1;
        $status->save();
    }
}
