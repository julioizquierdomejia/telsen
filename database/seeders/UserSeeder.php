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
        $role_user = Role::where('name', 'user')->first();
        $role_reception = Role::where('name', 'reception')->first();
        $role_worker = Role::where('name', 'worker')->first();

        /*$user = new User();
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
        $user->roles()->attach($role_superadmin);*/

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


        /*$user = new User();
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
        $user->roles()->attach($role_worker);

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
        $user->roles()->attach($role_worker);*/

        $user = new User();
        $user->email = 'omer.caro.rios@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'OMER';
        $user_data->last_name = 'CARO';
        $user_data->mother_last_name = 'RIOS';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 1;
        $user_area->save();

        $user->roles()->attach($role_superadmin);

        //Coordinador
        $user = new User();
        $user->email = 'arias.guitarra@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'TAKECHI DARIO';
        $user_data->last_name = 'GUTARRA';
        $user_data->mother_last_name = 'ARIAS';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 1;
        $user_area->save();
        $user->roles()->attach($role_superadmin);

        //Coordinador
        $user = new User();
        $user->email = 'kelwin.asencios@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'KELWIN';
        $user_data->last_name = 'ASENCIOS';
        $user_data->mother_last_name = 'MIGUEL';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'roberto.condori@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'ROBERTO ALEJANDRO';
        $user_data->last_name = 'CONDORI';
        $user_data->mother_last_name = 'MERINO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'julioc.cruz@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JULIO CESAR';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'CUEVA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'juane.estacio@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JUAN EDUARDO';
        $user_data->last_name = 'ESTACIO';
        $user_data->mother_last_name = 'SEGUNDO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'teodoroc.palomino@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'TEODORO CLETO';
        $user_data->last_name = 'PALOMINO';
        $user_data->mother_last_name = 'MACHAHUAY';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'emerzon.cubas@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'EMERZON';
        $user_data->last_name = 'CUBAS';
        $user_data->mother_last_name = 'SANTES';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 6;
        $user_area->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'celso.ramos.mora@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'CELSO';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'MORA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'jimmy.chaupin@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JIMMY JAIR';
        $user_data->last_name = 'CHAUPIN';
        $user_data->mother_last_name = 'FRANCO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'roberto.bardales@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'ROBERTO LLOVANNY';
        $user_data->last_name = 'BARDALES';
        $user_data->mother_last_name = 'PACAYA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'javier.casas.esteban@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JAVIER ROBERTO';
        $user_data->last_name = 'CASAS';
        $user_data->mother_last_name = 'ESTEBAN';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'juan.manayay.quispe@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JUAN JESUS';
        $user_data->last_name = 'MANAYAY';
        $user_data->mother_last_name = 'QUISPE';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jhon.ortiz.saravia@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JHON NEYSSER';
        $user_data->last_name = 'ORTIZ';
        $user_data->mother_last_name = 'SARAVIA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'sebastian.zelada.trigoso@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'SEBASTIAN';
        $user_data->last_name = 'ZELADA';
        $user_data->mother_last_name = 'TRIGOSO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 7;
        $user_area->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'fredy.sifuentes.flores@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'FREDY ANTONIO';
        $user_data->last_name = 'SIFUENTES';
        $user_data->mother_last_name = 'FLORES';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 8;
        $user_area->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'kelvin.gomez.medina@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'KELVIN JOSE';
        $user_data->last_name = 'GOMEZ';
        $user_data->mother_last_name = 'MEDINA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 8;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'dani.portillo.faria@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'DANI ENRIQUE';
        $user_data->last_name = 'PORTILLO';
        $user_data->mother_last_name = 'FARIA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 8;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'luis.rojas.tacuchi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'LUIS RICARDO';
        $user_data->last_name = 'ROJAS';
        $user_data->mother_last_name = 'TACUCHI';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 8;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'andre.ayasta.ibanez@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'ANDRE ALBERTO';
        $user_data->last_name = 'AYASTA';
        $user_data->mother_last_name = 'IBAÑEZ';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 11;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'felix.puse.herrera@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'FELIX VICENTE';
        $user_data->last_name = 'PUSE';
        $user_data->mother_last_name = 'HERRERA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 12;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'freddy.rios.paredes@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'FREDDY ALEJANRO';
        $user_data->last_name = 'RIOS';
        $user_data->mother_last_name = 'PAREDES';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 8;
        $user_area->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'jose.abanto.toribio@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JOSE ANTONIO';
        $user_data->last_name = 'ABANTO';
        $user_data->mother_last_name = 'TORIBIO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'luis.alejo.palomo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'LUIS EDUARDO';
        $user_data->last_name = 'ALEJO';
        $user_data->mother_last_name = 'PALOMO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jason.cabanillas.pena@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JASON JAVIER';
        $user_data->last_name = 'CABANILLAS';
        $user_data->mother_last_name = 'PEÑA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'donayre.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'DONAYRE RODRIGO';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'ESCALANTE';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'elmer.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'ELMER JESUS';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'ESCALANTE';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'eduard.cruz.escalante@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'EDUARD CRISTIAMS';
        $user_data->last_name = 'DE LA CRUZ';
        $user_data->mother_last_name = 'PASION';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'jesus.ramos.sanchez@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'JESUS HONORES';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'SANCHEZ';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'takechi.gutarra.arias@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'TAKECHI DARIO';
        $user_data->last_name = 'GUTARRA';
        $user_data->mother_last_name = 'ARIAS';
        $user_data->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'mario.ramos.mora@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'MARIO';
        $user_data->last_name = 'RAMOS';
        $user_data->mother_last_name = 'MORA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 13;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'wilmer.obregon.tarazona@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'WILMER JOEL';
        $user_data->last_name = 'OBREGON';
        $user_data->mother_last_name = 'TARAZONA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 10;
        $user_area->save();
        $user->roles()->attach($role_worker);

        //Coordinador
        $user = new User();
        $user->email = 'ricardo.zafra.rengifo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'RICARDO ARTURO';
        $user_data->last_name = 'ZAFRA';
        $user_data->mother_last_name = 'RENGIFO';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 2;
        $user_area->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->email = 'francisco.toribio.vergara@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'FRANCISCO ALFONSO';
        $user_data->last_name = 'TORIBIO';
        $user_data->mother_last_name = 'VERGARA';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 3;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'carlos.tume.diaz@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'CARLOS WALTHER';
        $user_data->last_name = 'TUME';
        $user_data->mother_last_name = 'DIAZ';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 3;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'manuel.renjifo.torres@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'MANUEL FERNANDO';
        $user_data->last_name = 'RENJIFO';
        $user_data->mother_last_name = 'TORRES';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 4;
        $user_area->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'edward.romero.pasion@gmail.com';
        $user->password = bcrypt('12345678');
        $user->status = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'EDWARD ENRIQUE';
        $user_data->last_name = 'ROMERO';
        $user_data->mother_last_name = 'PASION';
        $user_data->save();
        //Area Usuario
        $user_area = new UserArea();
        $user_area->user_id = $user->id;
        $user_area->area_id = 4;
        $user_area->save();
        $user->roles()->attach($role_worker);

    }
}
