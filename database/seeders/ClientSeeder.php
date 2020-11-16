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
        $client->ruc = "20261677955"; 
        $client->razon_social = "NEXA RESOURCES - CJM"; 
        $client->direccion = "Car. Car. Central Nro. 9.5 Cajamarquilla (Carr.Central Km.9.5 Desvio a Huachipa)"; 
        $client->email = "nexa@gmail.com"; 
        $client->client_type_id = 1; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20259829594"; 
        $client->razon_social = "REFINERIA LA PAMPILLA"; 
        $client->direccion = "Ventanilla KM25 - Ventanilla - Callao - Callao"; 
        $client->email = "pampilla@gmail.com"; 
        $client->client_type_id = 1; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20602042201"; 
        $client->razon_social = "ZITRON"; 
        $client->direccion = "Cal. las Orquideas Nro. 2750 - Lince"; 
        $client->email = "zitron@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20100056802"; 
        $client->razon_social = "COMPAÑÍA MINERA CONDESTABLE"; 
        $client->direccion = "Av. Manuel Olguin Nro. 501 Int. 803 - Santiago de Surco"; 
        $client->email = "condestable@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20424964990"; 
        $client->razon_social = "CARTONES VILLA MARINA S.A.- CARVIMSA"; 
        $client->direccion = "Car. Panamericana Sur Km.19 Nro. Mz-F Int. Lt.2 Fnd. Asoc. la Concordia (Margen Izquierda) - Villa el Salvador"; 
        $client->email = "carvimsa@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20101026001";
        $client->razon_social = "CERAMICA LIMA S A - CELIMA"; 
        $client->direccion = "Av. el Polo Nro. 405 - Santiago de Surco"; 
        $client->email = "celima@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20107290177";
        $client->razon_social = "MINERA COLQUISIRI S.A."; 
        $client->direccion = "Av. del Parque Norte Nro. 724 - San Isidro"; 
        $client->email = "colquisiri@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20513462388";
        $client->razon_social = "DP WORLD CALLAO S.R.L."; 
        $client->direccion = "Av. Manco Capac Nro. 113 - Callao"; 
        $client->email = "dp@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();

        $client = new Client();
        $client->ruc = "20100971772";
        $client->razon_social = "TASA"; 
        $client->direccion = " Jr. Vittore Scarpazza Carpacc Nro. 250 - San Borja"; 
        $client->email = "tasa@gmail.com"; 
        $client->client_type_id = 2; 
        $client->enabled = 1;
        $client->save();
    }
}
