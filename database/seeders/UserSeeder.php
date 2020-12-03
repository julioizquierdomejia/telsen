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
        $role_coordinator = Role::where('name', 'supervisor')->first();
        $role_worker = Role::where('name', 'worker')->first();

        $crear_ot = Role::where('name', 'crear_ot')->first();
        $evaluador = Role::where('name', 'evaluador')->first();
        $aprobador_de_evaluaciones = Role::where('name', 'aprobador_de_evaluaciones')->first();
        $tarjeta_de_costo = Role::where('name', 'tarjeta_de_costo')->first();
        $cotizador_tarjeta_de_costo = Role::where('name', 'cotizador_tarjeta_de_costo')->first();
        $aprobador_cotizacion_tarjeta_de_costo = Role::where('name', 'aprobador_cotizacion_tarjeta_de_costo')->first();
        $rdi = Role::where('name', 'rdi')->first();
        $aprobador_rdi = Role::where('name', 'aprobador_rdi')->first();
        $fecha_de_entrega = Role::where('name', 'fecha_de_entrega')->first();
        


        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
        $user = new User();
        $user->email = 'crear@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'crear';
        $user_data->last_name = 'crear';
        $user_data->mother_last_name = 'crear';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($crear_ot);


        $user = new User();
        $user->email = 'evaluar@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'evaluar';
        $user_data->last_name = 'evaluar';
        $user_data->mother_last_name = 'evaluar';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($evaluador);

        $user = new User();
        $user->email = 'aprobarevaluaciones@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'aprobarevaluaciones';
        $user_data->last_name = 'aprobarevaluaciones';
        $user_data->mother_last_name = 'aprobarevaluaciones';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($aprobador_de_evaluaciones);

        $user = new User();
        $user->email = 'tarjeta@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'tarjeta';
        $user_data->last_name = 'tarjeta';
        $user_data->mother_last_name = 'tarjeta';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($tarjeta_de_costo);

        $user = new User();
        $user->email = 'cotizar_tarjeta@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'cotizar_tarjeta';
        $user_data->last_name = 'cotizar_tarjeta';
        $user_data->mother_last_name = 'cotizar_tarjeta';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($cotizador_tarjeta_de_costo);

        $user = new User();
        $user->email = 'aprobarcotizacion@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'aprobarcotizacion';
        $user_data->last_name = 'aprobarcotizacion';
        $user_data->mother_last_name = 'aprobarcotizacion';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($aprobador_cotizacion_tarjeta_de_costo);

        $user = new User();
        $user->email = 'rdi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'rdi';
        $user_data->last_name = 'rdi';
        $user_data->mother_last_name = 'rdi';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($rdi);

        $user = new User();
        $user->email = 'aprobarrdi@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'aprobarrdi';
        $user_data->last_name = 'aprobarrdi';
        $user_data->mother_last_name = 'aprobarrdi';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($aprobador_rdi);


        $user = new User();
        $user->email = 'fecha@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'fecha';
        $user_data->last_name = 'fecha';
        $user_data->mother_last_name = 'fecha';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 1;
        $user_data->save();
        //vamos a relacionar roles con usuarios
        $user->roles()->attach($fecha_de_entrega);


        

        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

        /*$user = new User();
        $user->email = 'julio.izquierdo.mejia@gmail.com';
        $user->password = bcrypt('M4r14Jul14123456');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'julio';
        $user_data->last_name = 'izquierdo';
        $user_data->mother_last_name = 'mejia';
        $user_data->user_phone = 912345678;
        $user_data->save();

        //vamos a relacionar roles con usuarios
        $user->roles()->attach($role_superadmin);*/

        $user = new User();
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('admin');
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

        //-------------------
        //ADMINISTRADOR
        $user = new User();
        $user->email = 'omer.caro.rios@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'OMER';
        $user_data->last_name = 'CARO';
        $user_data->mother_last_name = 'RIOS';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'luis.hidalgo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'LUIS';
        $user_data->last_name = 'HIDALGO';
        $user_data->mother_last_name = '';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'toribio.perez.eduardo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'TORIBIO';
        $user_data->last_name = 'PEREZ';
        $user_data->mother_last_name = 'EDUARDO';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'toribio.perez.arturo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'TORIBIO';
        $user_data->last_name = 'PEREZ';
        $user_data->mother_last_name = 'ARTURO';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'fiestas.aguirre.sadith@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'SADITH';
        $user_data->last_name = 'FIESTAS';
        $user_data->mother_last_name = 'AGUIRRE';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

        //ADMINISTRADOR
        $user = new User();
        $user->email = 'zafra.rengifo.ricardo.arturo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->user_id = $user->id;
        $user_data->name = 'RICARDO ARTURO';
        $user_data->last_name = 'ZAFRA';
        $user_data->mother_last_name = 'RENGIFO';
        $user_data->user_phone = 912345678;
        $user_data->area_id = 2;
        $user_data->save();
        $user->roles()->attach($role_superadmin);

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
        $user->roles()->attach($role_coordinator);

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
        $user->roles()->attach($role_coordinator);

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
        $user->roles()->attach($role_coordinator);

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
        $user->roles()->attach($role_coordinator);

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

        /*$user = new User();
        $user->email = 'andre.ayasta.ibanez@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'ANDRE ALBERTO';
        $user_data->last_name = 'AYASTA';
        $user_data->mother_last_name = 'IBAÑEZ';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 12;
        $user_data->save();
        $user->roles()->attach($role_worker);*/

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
        $user->roles()->attach($role_coordinator);

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

        //Coordinador
        /*$user = new User();
        $user->email = 'takechi.gutarra.arias@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'TAKECHI DARIO';
        $user_data->last_name = 'GUTARRA';
        $user_data->mother_last_name = 'ARIAS';
        $user_data->area_id = 14;
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->user_id = $user->id;
        $user_data->save();
        $user->roles()->attach($role_coordinator);*/

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

        //Coordinador
        /*$user = new User();
        $user->email = 'ricardo.zafra.rengifo@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'RICARDO ARTURO';
        $user_data->last_name = 'ZAFRA';
        $user_data->mother_last_name = 'RENGIFO';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 3;
        $user_data->save();
        $user->roles()->attach($role_coordinator);

        $user = new User();
        $user->email = 'francisco.toribio.vergara@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'FRANCISCO ALFONSO';
        $user_data->last_name = 'TORIBIO';
        $user_data->mother_last_name = 'VERGARA';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 4;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'carlos.tume.diaz@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'CARLOS WALTHER';
        $user_data->last_name = 'TUME';
        $user_data->mother_last_name = 'DIAZ';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 4;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'manuel.renjifo.torres@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'MANUEL FERNANDO';
        $user_data->last_name = 'RENJIFO';
        $user_data->mother_last_name = 'TORRES';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 5;
        $user_data->save();
        $user->roles()->attach($role_worker);

        $user = new User();
        $user->email = 'edward.romero.pasion@gmail.com';
        $user->password = bcrypt('12345678');
        $user->enabled = 1;
        $user->save();
        $user_data = new UserData();
        $user_data->name = 'EDWARD ENRIQUE';
        $user_data->last_name = 'ROMERO';
        $user_data->mother_last_name = 'PASION';
        $user_data->user_phone = 912345678;
        $user_data->user_id = $user->id;
        $user_data->area_id = 5;
        $user_data->save();
        $user->roles()->attach($role_worker);*/

    }
}
