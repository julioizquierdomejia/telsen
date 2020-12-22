<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OtWorkReason;
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
        $reason = new OtWorkReason();
        $reason->name = "En Proceso";
        $reason->code = "start";
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "En Proceso";
        $reason->code = "continue";
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Detenido por falta de insumos";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Detenido por orden del cliente";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Detenido por orden de gerencia";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Detenido por orden de jefe de planta";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Detenido por baja prioridad";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Término de jornada laboral";
        $reason->code = $code++;
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Terminado";
        $reason->code = "end";
        $reason->save();

        $reason = new OtWorkReason();
        $reason->name = "Reanudado";
        $reason->code = "restart";
        $reason->save();

        //Estados para revisar trabajos por el supervisor
        $work_status = new WorkStatus();
        $work_status->name = "approved";
        $work_status->save();
        $work_status = new WorkStatus();
        $work_status->name = "disapproved";
        $work_status->save();
        /*$work_status = new WorkStatus();
        $work_status->name = "finished";
        $work_status->save();*/
    }
}
