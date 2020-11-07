<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Service;

class AreaServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Areas
        $area = new Area();
        $area->name = 'PRUEBAS ELECTRICAS INGRESO';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'REBOBINADO DE ESTATOR';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'MANTENIMIENTO DE ROTOR';
        $area->enabled = 1;
        $area->save();

        //Servicios
        $service = new Service();
        $service->name = 'DESMONTAJE Y MONTAJE DE MOTOR';
        $service->area_id = 1;
        $service->enabled = 1;
        $service->save();

        $service = new Service();
        $service->name = 'PRUEBAS CON EQUIPO BAKER D65R';
        $service->area_id = 1;
        $service->enabled = 1;
        $service->save();

        $service = new Service();
        $service->name = 'Nº DE ALAMBRE';
        $service->area_id = 2;
        $service->enabled = 1;
        $service->save();

        $service = new Service();
        $service->name = 'MANTENIMIENTO DE ROTOR';
        $service->area_id = 3;
        $service->enabled = 1;
        $service->save();
    }
}
