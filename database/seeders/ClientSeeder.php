<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $client->ruc = "20109072177"; 
        $client->razon_social = "CENCOSUD RETAIL PERU S.A."; 
        $client->direccion = "Cal. Augusto Angulo Nro. 130"; 
        $client->telefono = "912345678"; 
        $client->celular = "912345678"; 
        $client->contacto = "CENCOSUD S A";
        $client->telefono_contacto = "912345678";
        $client->correo = "metro@gmail.com"; 
        $client->info = "info"; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20100128056"; 
        $client->razon_social = "SAGA FALABELLA S A"; 
        $client->direccion = "Cal. Augusto Angulo Nro. 130"; 
        $client->telefono = "912345678"; 
        $client->celular = "912345678"; 
        $client->contacto = "Saga Falabella";
        $client->telefono_contacto = "912345678";
        $client->correo = "sfalabella@gmail.com"; 
        $client->info = "info"; 
        $client->enabled = 1;
        $client->save();
    }
}
