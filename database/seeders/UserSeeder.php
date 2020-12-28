<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\RoleUser;
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
        
        User::query()->delete();
        RoleUser::query()->delete();
        UserData::query()->delete();

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

        //Anteriores usuarios
        //ADMINISTRADOR - Coordinador
        $user = new User();
        $user->email = 'arias.guitarra@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'TAKECHI DARIO';
        $user_data->last_name = 'GUTARRA';
        $user_data->mother_last_name = 'ARIAS';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        //Coordinador
        $user = new User();
        $user->email = 'kelwin.asencios@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'KELWIN';
        $user_data->last_name = 'ASENCIOS';
        $user_data->mother_last_name = 'MIGUEL';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 7;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        $user = new User();
        $user->email = 'roberto.condori@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'ROBERTO ALEJANDRO';
        $user_data->last_name = 'CONDORI';
        $user_data->mother_last_name = 'MERINO';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 7;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'julioc.cruz@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JULIO CESAR';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'CUEVA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 7;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'juane.estacio@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JUAN EDUARDO';
        $user_data->last_name = 'ESTACIO';
        $user_data->mother_last_name = 'SEGUNDO';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 7;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'teodoroc.palomino@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'TEODORO CLETO';
        $user_data->last_name = 'PALOMINO';
        $user_data->mother_last_name = 'MACHAHUAY';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 7;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'emerzon.cubas@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'EMERZON';
        $user_data->last_name = 'CUBAS';
        $user_data->mother_last_name = 'SANTES';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 7;
        $user_data->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'celso.ramos.mora@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'CELSO';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'MORA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 8;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        $user = new User();
        $user->email = 'jimmy.chaupin@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JIMMY JAIR';
        $user_data->last_name = 'CHAUPIN';
        $user_data->mother_last_name = 'FRANCO';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 8;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'roberto.bardales@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'ROBERTO LLOVANNY';
        $user_data->last_name = 'BARDALES';
        $user_data->mother_last_name = 'PACAYA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 8;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'javier.casas.esteban@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JAVIER ROBERTO';
        $user_data->last_name = 'CASAS';
        $user_data->mother_last_name = 'ESTEBAN';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 8;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'juan.manayay.quispe@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JUAN JESUS';
        $user_data->last_name = 'MANAYAY';
        $user_data->mother_last_name = 'QUISPE';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 8;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jhon.ortiz.saravia@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JHON NEYSSER';
        $user_data->last_name = 'ORTIZ';
        $user_data->mother_last_name = 'SARAVIA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 8;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'sebastian.zelada.trigoso@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'SEBASTIAN';
        $user_data->last_name = 'ZELADA';
        $user_data->mother_last_name = 'TRIGOSO';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 8;
        $user_data->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'fredy.sifuentes.flores@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'FREDY ANTONIO';
        $user_data->last_name = 'SIFUENTES';
        $user_data->mother_last_name = 'FLORES';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 9;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        $user = new User();
        $user->email = 'kelvin.gomez.medina@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'KELVIN JOSE';
        $user_data->last_name = 'GOMEZ';
        $user_data->mother_last_name = 'MEDINA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 9;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'dani.portillo.faria@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'DANI ENRIQUE';
        $user_data->last_name = 'PORTILLO';
        $user_data->mother_last_name = 'FARIA';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 9;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'luis.rojas.tacuchi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'LUIS RICARDO';
        $user_data->last_name = 'ROJAS';
        $user_data->mother_last_name = 'TACUCHI';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 9;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'felix.puse.herrera@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'FELIX VICENTE';
        $user_data->last_name = 'PUSE';
        $user_data->mother_last_name = 'HERRERA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 13;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'freddy.rios.paredes@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'FREDDY ALEJANRO';
        $user_data->last_name = 'RIOS';
        $user_data->mother_last_name = 'PAREDES';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 9;
        $user_data->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'jose.abanto.toribio@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JOSE ANTONIO';
        $user_data->last_name = 'ABANTO';
        $user_data->mother_last_name = 'TORIBIO';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_supervisor);

        $user = new User();
        $user->email = 'luis.alejo.palomo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'LUIS EDUARDO';
        $user_data->last_name = 'ALEJO';
        $user_data->mother_last_name = 'PALOMO';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jason.cabanillas.pena@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JASON JAVIER';
        $user_data->last_name = 'CABANILLAS';
        $user_data->mother_last_name = 'PEÑA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'donayre.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'DONAYRE RODRIGO';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'ESCALANTE';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'elmer.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'ELMER JESUS';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'ESCALANTE';
        $user_data->user_id = $user->id;
        $user_data->user_phone = 912345678;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'eduard.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'EDUARD CRISTIAMS';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'PASION';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jesus.ramos.sanchez@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'JESUS HONORES';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'SANCHEZ';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'mario.ramos.mora@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'MARIO';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'MORA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 14;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'wilmer.obregon.tarazona@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'WILMER JOEL';
        $user_data->last_name = 'OBREGON';
        $user_data->mother_last_name = 'TARAZONA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 11;
        $user_data->save();
        $user->roles()->attach($role_worker);

    }
}
