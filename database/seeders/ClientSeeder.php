<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\ClientType;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_type = new ClientType();
        $client_type->name = "RDI";
        $client_type->enabled = 1;
        $client_type->save();

        $client_type = new ClientType();
        $client_type->name = "No afiliado";
        $client_type->enabled = 1;
        $client_type->save();

        $client = new Client();
        $client->ruc = "20556487431";
        $client->razon_social = "BEYOND STUDIOS MULTIMEDIA S.A.C."; 
        $client->direccion = "Cal. Lima 123"; 
        $client->telefono = "912345678"; 
        $client->celular = "912345678";
        $client->contacto = "BEYOND STUDIOS";
        $client->telefono_contacto = "912345678";
        $client->correo = "bstudios@gmail.com"; 
        $client->info = "info";
        $client->client_type_id = 1;
        $client->enabled = 1;
        $client->save();

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
        $client->client_type_id = 1;
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
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();
    }
}
