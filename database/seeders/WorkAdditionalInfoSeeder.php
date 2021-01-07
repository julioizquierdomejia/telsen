<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkAdditionalInformation;
use App\Models\WorkAdditionalInformationCol;

class WorkAdditionalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_addinfos = array(
            array(
                'name' => 'Resumen de calibraciones técnicas',
                'public' => 1,
                'cols' => array (
                    'Descripción',
                    'Lado Delantero (Pto. 1)',
                    'Lado Posterior (Pto. 2)',
                    'Observación',
                )
            ),
        );

        foreach ($work_addinfos as $key => $work_ai_item) {
            $cols = $work_ai_item['cols'];
            $work_addinfo = new WorkAdditionalInformation();
            $work_addinfo->name = $work_ai_item['name'];
            $work_addinfo->public = $work_ai_item['public'];
            $work_addinfo->save();
            foreach ($cols as $key => $item) {
                $work_addinfo_col = new WorkAdditionalInformationCol();
                $work_addinfo_col->service_id = $item;
                $work_addinfo_col->save();
            }
        }

        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Embocinado de tapas';
        $work_addinfo->public = 1;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Metalizado de eje';
        $work_addinfo->public = 0;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Pruebas eléctricas';
        $work_addinfo->public = 1;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Prueba de Motor en Vacío';
        $work_addinfo->public = 1;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Nuevo cuadro';
        $work_addinfo->public = 1;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Niveles de vibración';
        $work_addinfo->public = 1;
        $work_addinfo->save();
        $work_addinfo = new WorkAdditionalInformation();
        $work_addinfo->name = 'Pruebas dinámicas Baker';
        $work_addinfo->public = 1;
        $work_addinfo->save();

        $work_addinfo_col = new WorkAdditionalInformationCol();
        $work_addinfo_col->table_id = 'Descripción';
        $work_addinfo_col->col_name = 'Descripción';
        $work_addinfo_col->col_type = 'Descripción';
        $work_addinfo_col->service_id = 'Descripción';
        $work_addinfo_col->save();
    }
}
