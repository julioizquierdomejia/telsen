<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\DB::table('roles')->truncate();


        $role = new Role();
        $role->name = 'superadmin';
        $role->description = 'Super administrador del sistema';
        $role->save();

        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrador del sistema';
        $role->save();

        $role = new Role();
        $role->name = 'crear_ot';
        $role->description = 'Encargado de Crear las OT';
        $role->save();

        $role = new Role();
        $role->name = 'evaluador';
        $role->description = 'Para evaluaciones Electricas y Mecánicas';
        $role->save();

        $role = new Role();
        $role->name = 'aprobador_de_evaluaciones';
        $role->description = 'Es el resonsable de aprobar las evaluaciones';
        $role->save();

        $role = new Role();
        $role->name = 'tarjeta_de_costo';
        $role->description = 'Encargado de generar la tarjeta de costo';
        $role->save();

        $role = new Role();
        $role->name = 'cotizador_tarjeta_de_costo';
        $role->description = 'Encargado de cotización de tarjeta de costo';
        $role->save();

        $role = new Role();
        $role->name = 'aprobador_cotizacion_tarjeta_de_costo';
        $role->description = 'Encargado de aprobar cotización de tarjeta de costo';
        $role->save();

        $role = new Role();
        $role->name = 'rdi';
        $role->description = 'Encargado de Generar los RDI';
        $role->save();

        $role = new Role();
        $role->name = 'aprobador_rdi';
        $role->description = 'Encargado de aprobar los RDI';
        $role->save();

        $role = new Role();
        $role->name = 'fecha_de_entrega';
        $role->description = 'Encargado de Generar la fecha de entrega';
        $role->save();

        $role = new Role();
        $role->name = 'client';
        $role->description = 'Cliente';
        $role->save();

        $role = new Role();
        $role->name = 'supervisor';
        $role->description = 'Coordinador';
        $role->save();

        $role = new Role();
        $role->name = 'worker';
        $role->description = 'Trabajador';
        $role->save();
    }
}
