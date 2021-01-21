<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use App\Models\OtWorkReason;
use App\Models\WorkStatus;

class OtWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$code = 1;
        $work_status = new WorkStatus();
        $work_status->name = "En Proceso - iniciado";
        $work_status->code = "start";
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "En Proceso - continuación";
        $work_status->code = "continue";
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Detenido por falta de insumos";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Detenido por orden del cliente";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Detenido por orden de gerencia";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Detenido por orden de jefe de planta";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Detenido por baja prioridad";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Término de jornada laboral";
        $work_status->code = $code++;
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Terminado";
        $work_status->code = "end";
        $work_status->save();

        $work_status = new WorkStatus();
        $work_status->name = "Reanudado";
        $work_status->code = "restart";
        $work_status->save();

        //Estados para revisar trabajos por el supervisor
        $work_status = new WorkStatus();
        $work_status->name = "Aprobado";
        $work_status->code = "approved";
        $work_status->save();
        $work_status = new WorkStatus();
        $work_status->name = "Desaprobado";
        $work_status->code = "disapproved";
        $work_status->save();
    }
}
