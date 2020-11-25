<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RotorCodRodajePt1;
use App\Models\RotorCodRodajePt2;

class RotorCodRodajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //RotorCodRodajeP1
        $status = new RotorCodRodajePt1();
        $status->name = '6317 C3';
        $status->asiento_rodaje = 'Ø INT 85';
        $status->alojamiento_rodaje = 'Ø EXT 180';
        $status->enabled = 1;
        $status->save();

        $status = new RotorCodRodajePt1();
        $status->name = '6314 C3';
        $status->asiento_rodaje = 'Ø INT 70';
        $status->alojamiento_rodaje = 'Ø EXT 150';
        $status->enabled = 1;
        $status->save();

        //RotorCodRodajeP2
        $status = new RotorCodRodajePt2();
        $status->name = '7322 BM';
        $status->asiento_rodaje = 'Ø INT 110';
        $status->alojamiento_rodaje = 'Ø EXT 240';
        $status->enabled = 1;
        $status->save();

        $status = new RotorCodRodajePt2();
        $status->name = 'UN 222 ECP C3';
        $status->asiento_rodaje = 'Ø INT 110';
        $status->alojamiento_rodaje = 'Ø EXT 200';
        $status->enabled = 1;
        $status->save();
    }
}
