<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RotorCodRodajePt1;
use App\Models\RotorCodRodajePt2;

use Illuminate\Support\Facades\DB;

class RotorCodRodajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    function insertquote($value) {
        return "'$value'";
    }

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        RotorCodRodajePt1::truncate();
        RotorCodRodajePt2::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $lineNumber = 1;
        if (($handle = fopen(base_path("public/rotor_cod_rodaje_pt.csv"), "r")) !== false) {
            while (($data = fgets($handle)) !== false) {
                if ($lineNumber === 1) {
                    $lineNumber++;
                    continue;
                }
                $lineNumber++;

                $row = str_getcsv($data, ";");

                /*//Tabla 1
                $createQuery = "INSERT INTO rotor_cod_rodaje_pt1s (name, asiento_rodaje, alojamiento_rodaje) VALUES (".self::insertquote($row[0]).", ".self::insertquote($row[1]).", ".self::insertquote($row[2]).")";
                DB::statement($createQuery, $row);

                //Tabla 2
                $createQuery = "INSERT INTO rotor_cod_rodaje_pt2s (name, asiento_rodaje, alojamiento_rodaje) VALUES (".self::insertquote($row[0]).", ".self::insertquote($row[1]).", ".self::insertquote($row[2]).")";
                DB::statement($createQuery, $row);*/

                $rotor_cod_rodaje_pt1 = new RotorCodRodajePt1;
                $rotor_cod_rodaje_pt1->name = $row[0];
                $rotor_cod_rodaje_pt1->asiento_rodaje = $row[1];
                $rotor_cod_rodaje_pt1->alojamiento_rodaje = $row[2];
                $rotor_cod_rodaje_pt1->save();

                $rotor_cod_rodaje_pt2 = new RotorCodRodajePt2;
                $rotor_cod_rodaje_pt2->name = $row[0];
                $rotor_cod_rodaje_pt2->asiento_rodaje = $row[1];
                $rotor_cod_rodaje_pt2->alojamiento_rodaje = $row[2];
                $rotor_cod_rodaje_pt2->save();

                //$this->command->info($row);
            }
            fclose($handle);
        }


    }
}
