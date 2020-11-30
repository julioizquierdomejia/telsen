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
        $role->description = 'Super administrador del sistema - config';
        $role->save();

        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrador del sistema';
        $role->save();

        $role = new Role();
        $role->name = 'user';
        $role->description = 'Usuario participante';
        $role->save();

        $role = new Role();
        $role->name = 'client';
        $role->description = 'Cliente';
        $role->save();

        $role = new Role();
        $role->name = 'coordinator';
        $role->description = 'Coordinador';
        $role->save();

        $role = new Role();
        $role->name = 'worker';
        $role->description = 'Trabajador';
        $role->save();
    }
}
