<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMechanicalEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanical_evaluations', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('client_id');
            //$table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            //$table->unsignedBigInteger('brand_id');
            //$table->foreign('brand_id')->references('id')->on('brands');

            $table->string('maquina')->nullable();
            $table->string('rpm');
            $table->string('hp_kw');

            $table->string('serie')->nullable();
            //$table->string('solped')->nullable();
            $table->string('placa_caract_orig')->nullable();
            $table->string('tapas')->nullable();
            $table->string('ventilador')->nullable();
            $table->string('caja_conexion')->nullable();
            $table->string('ejes')->nullable();
            $table->string('acople')->nullable();
            $table->string('bornera')->nullable();
            $table->string('fundas')->nullable();
            $table->string('chaveta')->nullable();
            $table->string('impro_seal')->nullable();
            $table->string('laberintos')->nullable();
            $table->string('estator')->nullable();

            $table->string('slam_muelle_p1')->nullable();
            $table->string('slam_muelle_p2')->nullable();
            $table->string('resortes_contra_tapas')->nullable();
            $table->string('alineamiento_paquete')->nullable();

            $table->string('rotor_deplexion_eje')->nullable();
            $table->string('rotor_valor_balanceo')->nullable();
            $table->string('rotor_cod_rodaje_p1')->nullable();
            $table->string('rotor_cod_rodaje_p2')->nullable();
            $table->string('rotor_asiento_rodaje_p1')->nullable();
            $table->string('rotor_asiento_rodaje_p2')->nullable();
            $table->string('rotor_eje_zona_acople_p1')->nullable();
            $table->string('rotor_eje_zona_acople_p2')->nullable();
            $table->string('rotor_medida_chaveta_p1')->nullable();
            $table->string('rotor_medida_chaveta_p2')->nullable();

            $table->string('estator_alojamiento_rodaje_tapa_p10')->nullable();
            $table->string('estator_alojamiento_rodaje_tapa_p20')->nullable();
            $table->string('estator_pestana_tapa_p1')->nullable();
            $table->string('estator_pestana_tapa_p2')->nullable();

            $table->string('estator_contra_tapa_interna_p1')->nullable();
            $table->string('estator_contra_tapa_interna_p2')->nullable();
            $table->string('estator_contra_tapa_externa_p1')->nullable();
            $table->string('estator_contra_tapa_externa_p2')->nullable();

            $table->string('estator_ventilador_0')->nullable();
            $table->string('estator_alabes')->nullable();
            $table->string('estator_caja_conexion')->nullable();
            $table->string('estator_tapa_conexion')->nullable();

            $table->text('observaciones')->nullable();

            $table->text('works')->nullable();

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
        Schema::table('mechanical_evaluations', function (Blueprint $table) {
            $table->dropForeign('mechanical_evaluations_ot_id_foreign');
        });
        Schema::dropIfExists('mechanical_evaluations');
    }
}
