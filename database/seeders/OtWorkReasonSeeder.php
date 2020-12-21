<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OtWorkReason;

class OtWorkReasonSeeder extends Seeder
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
        $reason->code = $code++;
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
        $reason->code = 99;
        $reason->save();
    }
}
