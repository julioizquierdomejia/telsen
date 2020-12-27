<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotorCodRodajePt2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotor_cod_rodaje_pt2s', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('asiento_rodaje');
            $table->string('alojamiento_rodaje');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotor_cod_rodaje_pt2s');
    }
}
