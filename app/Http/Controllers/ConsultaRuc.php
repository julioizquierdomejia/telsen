<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaRuc extends Controller
{
    public function consultaRuc($ruc){

		$ruta = "https://ruc.com.pe/api/beta/ruc";
		$token = "920eac07-e5af-4e07-a3ce-ed3b7442b237-3b521ac7-305c-4c8f-8dff-112f965c3f47";

		$rucaconsultar = '10178520739';

		$data = array(
		    "token"	=> $token,
		    "ruc"   => $ruc
		);
			
		$data_json = json_encode($data);

		// Invocamos el servicio a ruc.com.pe
		// Ejemplo para JSON
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ruta);
		curl_setopt(
			$ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			)
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta  = curl_exec($ch);
		curl_close($ch);

		$leer_respuesta = json_decode($respuesta, true);
		if (isset($leer_respuesta['errors'])) {
			//Mostramos los errores si los hay
		    return $leer_respuesta['errors'];
		} else {
			//Mostramos la respuesta
			//echo "Respuesta de la API:<br>";
			return $leer_respuesta;
		}
    }
}
