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
        $status->name = 'ot_created';
        $status->description = 'OT Creada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'me';
        $status->description = 'Evaluación Mecánica';
        $status->enabled = 1;
        $status->save();
        $status = new Status();
        $status->name = 'me_approved';
        $status->description = 'Evaluación Mecánica aprobada';
        $status->enabled = 1;
        $status->save();
        $status = new Status();
        $status->name = 'me_disapproved';
        $status->description = 'Evaluación Mecánica desaprobada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'ee';
        $status->description = 'Evaluación Eléctrica';
        $status->enabled = 1;
        $status->save();
        $status = new Status();
        $status->name = 'ee_approved';
        $status->description = 'Evaluación Eléctrica aprobada';
        $status->enabled = 1;
        $status->save();
        $status = new Status();
        $status->name = 'ee_disapproved';
        $status->description = 'Evaluación Eléctrica desaprobada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'cc';
        $status->description = 'Tarjeta de Costo';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'cc_waiting';
        $status->description = 'Cotización por aprobar';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'cc_approved';
        $status->description = 'Cotización aprobada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'cc_disapproved';
        $status->description = 'Cotización desaprobada';
        $status->enabled = 1;
        $status->save();

        //RDI
        $status = new Status();
        $status->name = 'rdi_waiting';
        $status->description = 'RDI por aprobar';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'rdi_approved';
        $status->description = 'RDI aprobada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'rdi_disapproved';
        $status->description = 'RDI desaprobada';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'delivery_generated';
        $status->description = 'Generación de fecha de entrega';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'pending_closure';
        $status->description = 'Pendiente de cierre';
        $status->enabled = 1;
        $status->save();

        $status = new Status();
        $status->name = 'ot_closure';
        $status->description = 'OT Finalizada';
        $status->enabled = 1;
        $status->save();
    }
}
