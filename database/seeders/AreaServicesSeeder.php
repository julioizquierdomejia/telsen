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
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Area::truncate();
        Service::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $areas = array(
            array(
                'name' => 'GERENCIA',
                'has_services' => 0,
                'services' => []
            ),
            array(
                'name' => 'ADMINISTRACIÓN',
                'has_services' => 0,
                'services' => []
            ),
            array(
                'name' => 'VIGILANCIA',
                'has_services' => 0,
                'services' => []
            ),
            array(
                'name' => 'CONDUCTOR',
                'has_services' => 0,
                'services' => []
            ),
            array(
                'name' => 'CLIENTES',
                'has_services' => 1,
                'services' => array (
                    'MANTENIMIENTO DE ESTATOR',
                    'MANTENIMIENTO DE FRENO ELÉCTRICO',
                    'SUMINISTRO DE 02 PRENSA ESTOPA',
                    'CAMBIO DE 02 RODAJES',
                    'CAMBIO DE EJE (Ø18 * 171 mm) - ACERO 1045',
                    'EMBOCINADO DE TAPA, ALOJAMIENTO DE RODAJE, PTO. 1 Y 2',
                    'CAMBIO DE RETÉN (7*16*7)',
                    'BALANCEO DINÁMICO',
                    'PRUEBAS BAKER',
                    'PINTURA',
                    //'ADICIONALES',
                    'CAMBIO DE GEBE DE ACOPLAMIENTO-PIÑON (Ø53.5 * 5.5 mm)',
                    'FABRICACION DE MACHINA PARA EXTRACCION DE PIÑON DE ACOPLE',
                )
            ),
            array(
                'name' => 'PRUEBAS',
                'has_services' => 1,
                'services' => array (
                    'TOMA DE DATOS',
                    'PRUEBAS ESTÁTICAS AISLAMIENTO BAKER INICIAL',
                    'PRUEBAS DE ARRANQUE',
                    'INFORME PRELIMINAR',
                    'PRUEBA DE ROTOR',
                    'PRUEBA DE ESTATOR',
                    'PRUEBAS EQUIPO CORE LESS',
                    'TARJETA DE COSTOS',
                    'PRUEBAS ESTÁTICAS BAKER SALIDA',
                    'PRUEBAS ELÉCTRICAS',
                    'INFORME FINAL',
                    'PROTOCOLO',
                    'INST. CABLES/ SENSORES PARA TAPAS',
                    'ACABADO FINAL (CABLES DE CONEXIÓN)',
                    'SUMINISTRO Y CAMBIO DE BORNERA',
                    'OTROS',
                )
            ),
            array(
                'name' => 'MECANICA',
                'has_services' => 1,
                'services' => array (
                    'DESMONTAJE',
                    'MONTAJE',
                    'TOMA DE DATOS MECÁNICA',
                    'OTROS: INFORME MECÁNICO',
                    'LIMPIEZA Y LAVADO/PARTES INTERNAS',
                    'LAVADO CON SOLVENTE DIELÉCTRICO Y LIMPIEZA DE PIEZAS',
                    'PINTADO PARTES DEL MOTOR',
                    'PRE TRATAMIENTO TERMICO',
                    'POS TRATAMIENTO TERMICO',
                    'SUMINISTRO E INSTALACIÓN DE RESISTENCIAS',
                    'SUMINISTRO CAMBIO ÁLABES',
                    'REPARACIÓN PAQUETE MAGNETICO',
                    'OTROS',
                )
            ),
            array(
                'name' => 'METALIZADO',
                'has_services' => 1,
                'services' => array (
                    'METALIZADO DE EJE',
                    'METALIZADO DE EJE, ASIENTO DE TURBINA',
                    'METALIZADO DE EJE, ASIENTO DE RODAJE',
                    'METALIZADO DE EJE, ASIENTO DE ACOPLE',
                    'METALIZADO DE ACOPLE, DIÁMETRO INTERIOR',
                    'METALIZADO DE EJE, ASIENTO DE VENTILADOR',
                    'METALIZADO DE TURBINA, DIÁMETRO INTERIOR',
                    'METALIZADO DE PESTAÑA DE TAPA',
                    'METALIZADO DE PESTAÑA DE TAPA DE RACHI',
                    'METALIZADO DE EJE, ASIENTO DE BABBITT',
                    'METALIZADO DE EJE, ASIENTO DE SELLO NYLON',
                    'METALIZADO DE EJE, ASIENTO DE RETÉN',
                    'OTROS',
                )
            ),
            array(
                'name' => 'MAESTRANZA',
                'has_services' => 1,
                'services' => array (
                    'MAQUINADO ADAPTACIÓN FELPA EN CONTRATAPA',
                    'MAQUINADO VENTILADOR DIAMETRO INTERIOR',
                    'MAQUINADO FABRICACIÓN/MAQUINADO CONTRATAPAS',
                    'MAQUINADO DE EJE',
                    'MAQUINADO ÁLABES',
                    'EMBOCINADO TAPA, ALOJAMIENTO ',
                    'EMBOCINADO',
                    'FABRICACIÓN CHAVETA',
                    'FABRICACIÓN CONTRATAPA EXTERIOR',
                    'FABRICACIÓN ENROSCADO',
                    'FABRICACIÓN TAPA DESFOGUE GRASA',
                    'TORNEADO DE COLECTOR',
                    'REPARACIÓN TAPA',
                    'REPARACIÓN FUNDA',
                    'REPARACIÓN CONTRATAPA',
                    'REPARACIÓN VENTILADOR',
                    'MAQUINADO PESTAÑAS',
                    'MAQUINADO EJE , ASIENO DE RODAJE',
                    'MAQUINADO EJE, ASIENTO DE ACOPLE',
                    'MAQUINADO EJE, ASIENTO DE VENILADOR',
                    'MAQUINADO EJE ASIENTO',
                    'MAQUINADO DE TURBINA DIAMETRO INTERIOR',
                    'RECIFICADO TAPA ALOJAMIENTO DE RODAJE',
                    'RECIFICADO EJE, ASIENTO CONTRATAPA INTERIOR',
                    'RECTIFICADO DE VENTILADOR DIAMETRO INTERIOR',
                    'RECTIFICADO EJE ASIENTO DE RODAJE',
                    'RECIFICADO ASIENTO DE VENTILADOR',
                    'RECTIFICADO DE TURBINA',
                    'BISELADO DE COLECTOR',
                    'OTROS',
                )
            ),
            array(
                'name' => 'REBOBINADO',
                'has_services' => 1,
                'services' => array (
                    'EXTRACCIÓN DEL BOBINADO ORIGINAL',
                    'PRUEBAS EQUIPO CORE LESS',
                    'LIMPIEZA ESTATOR',
                    'REBOBINADO ESTATOR',
                    'REBOBINADO DE ROTOR',
                    'PREPARACIÓN O FABRICACION DE NUEVAS BOBINAS PREFORMADAS',
                    'IMPREGNACION CON BARNIZ ',
                    'MONTAJE DE BOBINAS',
                    'RECUBRIMIENTO DE CABLES DE SALIDA',
                    'REPARACIÓN JAULA DE ARDILLA',
                    'OTROS',
                )
            ),
            array(
                'name' => 'SOLDADURA',
                'has_services' => 1,
                'services' => array (
                    'REPARACIÓN BASE',
                    'RELLENADO DE PESTAÑAS',
                    'REPARACIÓN DE FUNDA CAMBIO DE MALLA',
                    'REPARACIÓN DE TAPA CAJA DE CONEXIÓN',
                    'REPARACIÓN ALETAS DE ESTATOR',
                    'REPARACIÓN DE TAPA DE CAJA BORNERA',
                    'SOLDADO DE ALETA DE VENTILADOR',
                    'RELLENADO DE ASIENTO DE RODAJE',
                    'RELLENADO DE ASIENTO DE VENTILADOR',
                    'OTROS',
                )
            ),
            array(
                'name' => 'BALANCEO',
                'has_services' => 1,
                'services' => array (
                    'BALANCEO DINÁMICO',
                )
            ),
            array(
                'name' => 'ACABADOS',
                'has_services' => 1,
                'services' => array (
                    'LIMPIEZA',
                    'PINTADO',
                    'EMBALAJE',
                )
            ),
            array(
                'name' => 'ALMACÉN',
                'has_services' => 1,
                'services' => array (
                    'SUMINISTRO Y FABRICACIÓN FUNDA',
                    'FABRICACIÓN CHAVETA',
                    'REPARACIÓN PORTA ESCOBILLAS',
                    'MANDRINADO DE PESTAÑA ESTATOR',
                    'ARENADO DE RODETE Y TOLVA',
                    'BISELADO DE COLECTOR',
                    'FABRICACIÓN CANAL CHAVETERO',
                    'FABRICACIÓN CAJA BORNERA',
                    'FABRICACIÓN DE POLEA',
                    'REPARACIÓN DE CHUMACERAS',
                    'FRESADO DE ACOPLE',
                    'RODAJES ESPECIALES',
                    'ROLADO DE PLATINA',
                    'FABRICACIÓN DE RESORTES',
                    'RANURADO ARO DE COBRE',
                    'TREFILADO DE PLAINA',
                    'FABRICACIÓN DE PLATINAS DE COBRE',
                    'OTROS',
                )
            ),
        );

        foreach ($areas as $key => $area_item) {
            $services = $area_item['services'];
            $area = new Area();
            $area->name = $area_item['name'];
            $area->enabled = 1;
            $area->has_services = $area_item['has_services'];
            $area->save();
            foreach ($services as $key => $item) {
                $service = new Service();
                $service->name = $item;
                $service->area_id = $area->id;
                $service->enabled = 1;
                $service->save();
            }
        }

    }
}
