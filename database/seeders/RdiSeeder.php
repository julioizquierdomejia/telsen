<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use App\Models\Rdi;
use App\Models\RdiCriticalityType;
use App\Models\RdiMaintenanceType;

class RdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//RdiCriticalityType
        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'ATENCIÓN NORMAL';
        $rdictype->enabled = 1;
        $rdictype->save();

        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'URGENTE';
        $rdictype->enabled = 1;
        $rdictype->save();

        $rdictype = new RdiCriticalityType();
        $rdictype->name = 'EMERGENCIA';
        $rdictype->enabled = 1;
        $rdictype->save();

        //RdiMaintenanceType
        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'PREVENTIVO';
        $rdimtype->enabled = 1;
        $rdimtype->save();

        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'CORRECTIVO';
        $rdimtype->enabled = 1;
        $rdimtype->save();

        $rdimtype = new RdiMaintenanceType();
        $rdimtype->name = 'GARANTIA';
        $rdimtype->enabled = 1;
        $rdimtype->save();

        /*\DB::table('rdi_services')->insert(array (
            array ('name' => 'MANTENIMIENTO DE ESTATOR'),
            array ('name' => 'MANTENIMIENTO DE FRENO ELÉCTRICO'),
            array ('name' => 'SUMINISTRO DE 02 PRENSA ESTOPA'),
            array ('name' => 'CAMBIO DE 02 RODAJES',),
            array ('name' => 'CAMBIO DE EJE (Ø18 * 171 mm) - ACERO 1045',),
            array ('name' => 'EMBOCINADO DE TAPA, ALOJAMIENTO DE RODAJE, PTO. 1 Y 2',),
            array ('name' => 'CAMBIO DE RETÉN (7*16*7)'),
            array ('name' => 'BALANCEO DINÁMICO'),
            array ('name' => 'PRUEBAS BAKER'),
            array ('name' => 'PINTURA'),
            //array ('name' => 'ADICIONALES'),
            array ('name' => 'CAMBIO DE GEBE DE ACOPLAMIENTO-PIÑON (Ø53.5 * 5.5 mm)'),
            array ('name' => 'FABRICACION DE MACHINA PARA EXTRACCION DE PIÑON DE ACOPLE'),
        ));*/

    }
}
