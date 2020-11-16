<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\UserData;

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
        $role_user = Role::where('name', 'user')->first();
        $role_reception = Role::where('name', 'reception')->first();
        $role_evalmec = Role::where('name', 'mechanical')->first();
        $role_evalele = Role::where('name', 'electrical')->first();

        $user = new User();
        $user->email = 'julio.izquierdo.mejia@gmail.com';
        $user->password = bcrypt('M4r14Jul14123456');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'julio';
        $user_data->last_name = 'izquierdo';
        $user_data->mother_last_name = 'mejia';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);

        $user = new User();
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('admin');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'admin';
        $user_data->last_name = 'admin';
        $user_data->mother_last_name = 'admin';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);


        $user = new User();
        $user->email = 'arturotoribio@telsen.net';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'arturo';
        $user_data->last_name = 'toribio';
        $user_data->mother_last_name = 'toribio';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);


        $user = new User();
        $user->email = 'ruben.carhuayal@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'ruben';
        $user_data->last_name = 'carhuayal';
        $user_data->mother_last_name = 'carhuayal';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);

        $user = new User();
        $user->email = 'recepcion@gmail.com';
        $user->password = bcrypt('recepcion');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'recepcion';
        $user_data->last_name = 'recepcion';
        $user_data->mother_last_name = 'recepcion';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_reception);

        $user = new User();
        $user->email = 'evaluadorm@gmail.com';
        $user->password = bcrypt('evaluadorm');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'evaluadorm';
        $user_data->last_name = 'evaluadorm';
        $user_data->mother_last_name = 'evaluadorm';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_evalmec);

        $user = new User();
        $user->email = 'evaluadore@gmail.com';
        $user->password = bcrypt('evaluadore');
        $user->status = 1;
        $user->save();

        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'evaluadore';
        $user_data->last_name = 'evaluadore';
        $user_data->mother_last_name = 'evaluadore';
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_evalele);
    }
}
