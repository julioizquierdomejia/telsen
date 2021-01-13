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
                'service_id' => 6,
                'public' => 1,
                'mode' => 1, // 1=cabecera horizontal y vertical
                'cols' => array(
                    array (
                        'table_id' => 1,
                        'col_name' => 'Descripción',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Delantero (Pto. 1)',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Posterior (Pto. 2)',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Observación',
                        'col_type' => 'string',
                    )
                )
            ),

            array(
                'name' => 'Metalizado de eje',
                'service_id' => 42,
                'public' => 0,
                'mode' => 2, //2=cabecera horizontal y columnas verticales con cabeceras laterales
                'cols' => array(
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Acople | Asiento de rodaje',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Acople | Asiento acople',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Opuesto | Acople asiento de rodaje',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Lado Opuesto | Acople asiento acople',
                        'col_type' => 'string',
                    ),
                )
            ),

            array(
                'name' => 'Prueba de resistencia de aislamiento',
                'service_id' => 22,
                'public' => 1,
                'mode' => 3, //3=cabecera horizontal y datos
                'cols' => array(
                    array (
                        'table_id' => 1,
                        'col_name' => 'Tensión de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Tiempo de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Resistencia de aislamiento',
                        'col_type' => 'string',
                    ),
                )
            ),

            array(
                'name' => 'Prueba de Motor en Vacío', //Desde Pruebas electricas
                'service_id' => 22,
                'public' => 1,
                'mode' => 4, //4=
                'cols' => array(
                    array (
                        'table_id' => 1,
                        'col_name' => 'Corriente | R',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Corriente | S',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Corriente | T',
                        'col_type' => 'string',
                    ),

                    array (
                        'table_id' => 2,
                        'col_name' => 'Temperatura | Ambiente',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 2,
                        'col_name' => 'Temperatura | Aloj. Rod. Pto. 1',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 2,
                        'col_name' => 'Temperatura | Aloj. Rod. Pto. 2',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 2,
                        'col_name' => 'Temperatura | Carcaza',
                        'col_type' => 'string',
                    ),
                )
            ),

            array(
                'name' => 'Nuevo cuadro',
                'service_id' => 22,
                'public' => 0,
                'mode' => 1,
                'cols' => array(
                    array (
                        'table_id' => 3,
                        'col_name' => 'Tiempo de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 3,
                        'col_name' => 'N° Salidas',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 3,
                        'col_name' => 'Conexión',
                        'col_type' => 'string',
                    ),

                    array (
                        'table_id' => 3,
                        'col_name' => 'Tensión Nominal',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 3,
                        'col_name' => 'Velocidad',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 3,
                        'col_name' => 'Frecuencia',
                        'col_type' => 'string',
                    ),
                )
            ),

            array(
                'name' => 'Niveles de vibración', // Desde Pruebas mecanicas
                'service_id' => 22,
                'public' => 0,
                'mode' => 1,
                'cols' => array(
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado delantero (L.A.) | horizontal',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado delantero (L.A.) | vertical',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado delantero (L.A.) | axial',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado posterior (L.O.A.) | horizontal',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado posterior (L.O.A.) | vertical',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 4,
                        'col_name' => 'Lado posterior (L.O.A.) | axial',
                        'col_type' => 'string',
                    ),
                )
            ),

            array(
                'name' => 'Prueba de impulso (SURGE)', // Desde Pruebas dinamicas baker
                'service_id' => 9,
                'public' => 0,
                'mode' => 1,
                'cols' => array(
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 1 | Tensión de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 2 | Tensión de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 3 | Tensión de Prueba',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 1 | Porcentaje de Cruce',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 2 | Porcentaje de Cruce',
                        'col_type' => 'string',
                    ),
                    array (
                        'table_id' => 1,
                        'col_name' => 'Fase 3 | Porcentaje de Cruce',
                        'col_type' => 'string',
                    ),
                )
            ),
        );

        foreach ($work_addinfos as $key => $work_ai_item) {
            $cols = $work_ai_item['cols'];
            $work_addinfo = new WorkAdditionalInformation();
            $work_addinfo->name = $work_ai_item['name'];
            $work_addinfo->service_id = $work_ai_item['service_id'];
            $work_addinfo->mode = $work_ai_item['mode'];
            $work_addinfo->public = $work_ai_item['public'];
            $work_addinfo->save();
            foreach ($cols as $key => $item) {
                $work_addinfo_col = new WorkAdditionalInformationCol();
                $work_addinfo_col->work_add_info_id = $work_addinfo->id;
                $work_addinfo_col->table_id = $item['table_id'];
                $work_addinfo_col->col_name = $item['col_name'];
                $work_addinfo_col->col_type = $item['col_type'];
                $work_addinfo_col->save();
            }
        }

    }
}
