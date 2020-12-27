<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\UserData;
use App\Models\UserArea;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //colocamos en variables roles para poder relacionarlos
        $role_superadmin = Role::where('name', 'superadmin')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $role_crear_ot = Role::where('name', 'crear_ot')->first();
        $role_evaluador = Role::where('name', 'evaluador')->first();
        $role_aprobador_de_evaluaciones = Role::where('name', 'aprobador_de_evaluaciones')->first();
        $role_tarjeta_de_costo = Role::where('name', 'tarjeta_de_costo')->first();
        $role_cotizador_tarjeta_de_costo = Role::where('name', 'cotizador_tarjeta_de_costo')->first();
        $role_aprobador_cotizacion_tarjeta_de_costo = Role::where('name', 'aprobador_cotizacion_tarjeta_de_costo')->first();
        $role_rdi = Role::where('name', 'rdi')->first();
        $role_aprobador_rdi = Role::where('name', 'aprobador_rdi')->first();
        $role_fecha_de_entrega = Role::where('name', 'fecha_de_entrega')->first();
        $role_client = Role::where('name', 'client')->first();
        $role_supervisor = Role::where('name', 'supervisor')->first();
        $role_worker = Role::where('name', 'worker')->first();

        $user = new User();
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('_a$m&<x2o;#');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'admin';
        $user_data->last_name = 'admin';
        $user_data->mother_last_name = 'admin';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'admin_admin@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'admin';
        $user_data->last_name = 'admin';
        $user_data->mother_last_name = 'admin';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'crear_ot@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'crear_ot';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_crear_ot);

        $user = new User();
        $user->email = 'evaluador@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'evaluador';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_evaluador);

        $user = new User();
        $user->email = 'aprobador_de_evaluaciones@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'aprobador_de_evaluaciones';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_aprobador_de_evaluaciones);

        $user = new User();
        $user->email = 'tarjeta_de_costo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'tarjeta_de_costo';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_tarjeta_de_costo);

        $user = new User();
        $user->email = 'cotizador_tarjeta_de_costo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'cotizador_tarjeta_de_costo';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_cotizador_tarjeta_de_costo);

        $user = new User();
        $user->email = 'aprobador_cotizacion_tarjeta_de_costo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'aprobador_cotizacion_tarjeta_de_costo';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_aprobador_cotizacion_tarjeta_de_costo);

        $user = new User();
        $user->email = 'rdi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'rdi';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_rdi);

        $user = new User();
        $user->email = 'aprobador_rdi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'aprobador_rdi';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_aprobador_rdi);

        $user = new User();
        $user->email = 'fecha_de_entrega@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'fecha_de_entrega';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_fecha_de_entrega);

        $user = new User();
        $user->email = 'client@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'client';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_client);

        $user = new User();
        $user->email = 'supervisor@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'supervisor';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        $user = new User();
        $user->email = 'worker@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'worker';
        $user_data->last_name = '';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_worker);

    }
}
