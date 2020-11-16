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
        $area->name = 'CLIENTES';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'PRUEBAS';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'MECANICA';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'METALIZADO';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'MAESTRANZA';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'REBOBINADO';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'SOLDADURA';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'BALANCEO';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'ACABADOS';
        $area->enabled = 1;
        $area->save();

        $area = new Area();
        $area->name = 'ALMACÉN';
        $area->enabled = 1;
        $area->save();

        $area_id = 2; // 1 es para clientes

        //Servicios
        $service = new Service();$service->name = 'TOMA DE DATOS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS ESTÁTICAS AISLAMIENTO BAKER INICIAL';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS DE ARRANQUE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'INFORME PRELIMINAR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBA DE ROTOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBA DE ESTATOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS EQUIPO CORE LESS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'TARJETA DE COSTOS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS ESTÁTICAS BAKER SALIDA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS ELÉCTRICAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'INFORME FINAL';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PROTOCOLO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'INST. CABLES/ SENSORES PARA TAPAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'ACABADO FINAL (CABLES DE CONEXIÓN)';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'SUMINISTRO Y CAMBIO DE BORNERA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'DESMONTAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MONTAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'TOMA DE DATOS MECÁNICA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS: INFORME MECÁNICO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'LIMPIEZA Y LAVADO/PARTES INTERNAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'LAVADO CON SOLVENTE DIELÉCTRICO Y LIMPIEZA DE PIEZAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PINTADO PARTES DEL MOTOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRE TRATAMIENTO TERMICO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'POS TRATAMIENTO TERMICO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'SUMINISTRO E INSTALACIÓN DE RESISTENCIAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'SUMINISTRO CAMBIO ÁLABES';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN PAQUETE MAGNETICO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE TURBINA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE RODAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE ACOPLE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE ACOPLE, DIÁMETRO INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE VENTILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE TURBINA, DIÁMETRO INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE PESTAÑA DE TAPA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE PESTAÑA DE TAPA DE RACHI';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE BABBITT';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE SELLO NYLON';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'METALIZADO DE EJE, ASIENTO DE RETÉN';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'MAQUINADO ADAPTACIÓN FELPA EN CONTRATAPA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO VENTILADOR DIAMETRO INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO FABRICACIÓN/MAQUINADO CONTRATAPAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO DE EJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO ÁLABES';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'EMBOCINADO TAPA, ALOJAMIENTO ';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'EMBOCINADO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'FABRICACIÓN CHAVETA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'FABRICACIÓN CONTRATAPA EXTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'FABRICACIÓN ENROSCADO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'FABRICACIÓN TAPA DESFOGUE GRASA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'TORNEADO DE COLECTOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN TAPA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN FUNDA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN CONTRATAPA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN VENTILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO PESTAÑAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO EJE , ASIENO DE RODAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO EJE, ASIENTO DE ACOPLE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO EJE, ASIENTO DE VENILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO EJE ASIENTO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MAQUINADO DE TURBINA DIAMETRO INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECIFICADO TAPA ALOJAMIENTO DE RODAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECIFICADO EJE, ASIENTO CONTRATAPA INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECTIFICADO DE VENTILADOR DIAMETRO INTERIOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECTIFICADO EJE ASIENTO DE RODAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECIFICADO ASIENTO DE VENTILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECTIFICADO DE TURBINA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'BISELADO DE COLECTOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'EXTRACCIÓN DEL BOBINADO ORIGINAL';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PRUEBAS EQUIPO CORE LESS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'LIMPIEZA ESTATOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REBOBINADO ESTATOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REBOBINADO DE ROTOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PREPARACIÓN O FABRICACION DE NUEVAS BOBINAS PREFORMADAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'IMPREGNACION CON BARNIZ ';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'MONTAJE DE BOBINAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RECUBRIMIENTO DE CABLES DE SALIDA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN JAULA DE ARDILLA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'REPARACIÓN BASE ';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RELLENADO DE PESTAÑAS';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN DE FUNDA CAMBIO DE MALLA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN DE TAPA CAJA DE CONEXIÓN';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN ALETAS DE ESTATOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'REPARACIÓN DE TAPA DE CAJA BORNERA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'SOLDADO DE ALETA DE VENTILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RELLENADO DE ASIENTO DE RODAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'RELLENADO DE ASIENTO DE VENILADOR';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'OTROS';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'BALANCEO DINÁMICO';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;

        $service = new Service();$service->name = 'LIMPIEZA';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'PINTADO';$service->area_id = $area_id;$service->enabled = 1;$service->save();
        $service = new Service();$service->name = 'EMBALAJE';$service->area_id = $area_id;$service->enabled = 1;$service->save();

        $area_id += 1;


    }
}
