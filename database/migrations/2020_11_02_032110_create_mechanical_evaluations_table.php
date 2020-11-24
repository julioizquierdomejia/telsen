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

            $table->unsignedBigInteger('ot_id')->unique();
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

            $table->boolean('placa_caract_orig_has')->default(0);
            $table->boolean('tapas_has')->default(0);
            $table->boolean('ventilador_has')->default(0);
            $table->boolean('caja_conexion_has')->default(0);
            $table->boolean('ejes_has')->default(0);
            $table->boolean('acople_has')->default(0);
            $table->boolean('bornera_has')->default(0);
            $table->boolean('fundas_has')->default(0);
            $table->boolean('chaveta_has')->default(0);
            $table->boolean('impro_seal_has')->default(0);
            $table->boolean('laberintos_has')->default(0);
            $table->boolean('estator_has')->default(0);

            $table->string('otros')->nullable();

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
            $table->string('rotor_canal_chaveta_p1')->nullable();
            $table->string('rotor_medida_chaveta_p2')->nullable();
            $table->string('rotor_canal_chaveta_p2')->nullable();

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

            //$table->text('works')->nullable();

            $table->timestamps();
        });

        Schema::create('mechanical_evaluation_works', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('me_id');
            $table->foreign('me_id')->references('id')->on('mechanical_evaluations');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->string('description')->nullable();
            $table->string('medidas')->nullable();
            $table->string('qty')->nullable();
            $table->string('personal')->nullable();

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
        Schema::table('mechanical_evaluation_works', function (Blueprint $table) {
            $table->dropForeign('mechanical_evaluation_works_me_id_foreign');
            $table->dropForeign('mechanical_evaluation_works_service_id_foreign');
        });
        Schema::dropIfExists('mechanical_evaluations');
        Schema::dropIfExists('mechanical_evaluation_works');
    }
}
