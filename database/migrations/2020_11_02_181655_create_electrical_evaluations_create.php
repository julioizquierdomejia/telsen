<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricalEvaluationsCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_evaluations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ot_id')->unique();
            $table->foreign('ot_id')->references('id')->on('ots');

            //$table->string('solped')->nullable();
            $table->string('recepcionado_por')->nullable();
            //$table->string('marca');
            $table->string('potencia');
            $table->string('conex');
            $table->string('mod')->nullable();
            $table->string('voltaje');
            $table->string('nro_salida')->nullable();
            $table->string('tipo')->nullable();
            $table->string('amperaje');
            $table->string('rodla')->nullable();
            $table->string('nro_equipo')->nullable();
            $table->string('velocidad');
            $table->string('rodloa')->nullable();
            $table->string('frame')->nullable();
            $table->string('frecuencia');
            $table->string('lub')->nullable();
            $table->string('fs')->nullable();
            $table->string('encl')->nullable();
            $table->string('cos_o')->nullable();
            $table->string('aisl_clase')->nullable();
            $table->string('ef')->nullable();
            $table->string('cod')->nullable();
            $table->string('diseno_nema')->nullable();
            $table->string('ip')->nullable();
            $table->string('peso')->nullable();

            $table->timestamps();
        });

        Schema::create('eval_electrical_characteristics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('eel_id');
            $table->foreign('eel_id')->references('id')->on('electrical_evaluations');

            $table->string('marca')->nullable();
            $table->string('potencia')->nullable();
            $table->string('escudos')->nullable();
            $table->string('mod')->nullable();
            $table->string('voltaje')->nullable();
            $table->string('ejes')->nullable();
            $table->string('nro')->nullable();
            $table->string('amperaje')->nullable();
            $table->string('funda')->nullable();
            $table->string('frame')->nullable();
            $table->string('velocidad')->nullable();
            $table->string('acople')->nullable();
            $table->string('fs')->nullable();
            $table->string('encl')->nullable();
            $table->string('peso')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('otros')->nullable();

            $table->timestamps();
        });

        Schema::create('eval_electrical_reception', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('eel_id');
            $table->foreign('eel_id')->references('id')->on('electrical_evaluations');

            $table->string('placa_caract_orig')->nullable();
            $table->string('escudos')->nullable();
            $table->string('ventilador')->nullable();
            $table->string('caja_conexion')->nullable();
            $table->string('ejes')->nullable();
            $table->string('acople')->nullable();
            $table->string('bornera')->nullable();
            $table->string('funda')->nullable();
            $table->string('chaveta')->nullable();

            $table->boolean('placa_caract_orig_has')->default(0);
            $table->boolean('escudos_has')->default(0);
            $table->boolean('ventilador_has')->default(0);
            $table->boolean('caja_conexion_has')->default(0);
            $table->boolean('ejes_has')->default(0);
            $table->boolean('acople_has')->default(0);
            $table->boolean('bornera_has')->default(0);
            $table->boolean('funda_has')->default(0);
            $table->boolean('chaveta_has')->default(0);

            $table->string('otros')->nullable();
            $table->string('detalles')->nullable();

            $table->timestamps();
        });

        Schema::create('eval_electrical_test_in', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('eel_id');
            $table->foreign('eel_id')->references('id')->on('electrical_evaluations');

            //$table->string('motor')->nullable();
            $table->string('motor_aisl_m')->nullable();
            $table->string('motor_nro_salidas')->nullable();
            $table->string('motor_conexion')->nullable();
            $table->string('motor_volt_v')->nullable();
            $table->string('motor_amp_a')->nullable();
            $table->string('motor_rpm')->nullable();
            $table->string('motor_frec_hz')->nullable();
            $table->string('er_aisl_m')->nullable();
            $table->string('er_nro_salidas')->nullable();
            $table->string('er_conexion')->nullable();
            $table->string('er_volt_v')->nullable();
            $table->string('er_amp_a')->nullable();
            $table->string('er_nro_polos')->nullable();

            $table->timestamps();
        });

        Schema::create('eval_electrical_transformer', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('eel_id');
            $table->foreign('eel_id')->references('id')->on('electrical_evaluations');

            $table->string('tap')->nullable();
            $table->string('aisl_m')->nullable();
            $table->string('nro_salidas')->nullable();
            $table->string('conexion')->nullable();
            $table->string('volt_v')->nullable();
            $table->string('amp_a')->nullable();
            $table->string('nro_polos')->nullable();
            $table->string('aisl_m_at_masa')->nullable();
            $table->string('st_masa')->nullable();
            $table->string('et_at')->nullable();
            $table->string('grupo_conex')->nullable();
            $table->string('polaridad')->nullable();
            $table->string('relac_transf')->nullable();
            $table->string('otp')->nullable();
            $table->string('tec')->nullable();
            $table->string('amp')->nullable();
            $table->string('rig_diel_aceite')->nullable();
            $table->string('ruv')->nullable();
            $table->string('rv_w')->nullable();
            $table->string('rw_u')->nullable();
            $table->string('ru_v')->nullable();
            $table->string('rv_u')->nullable();
            $table->string('ww')->nullable();

            $table->timestamps();
        });

        Schema::create('electrical_evaluation_works', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('me_id');
            $table->foreign('me_id')->references('id')->on('electrical_evaluations');

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
        Schema::table('electrical_evaluations', function (Blueprint $table) {
            $table->dropForeign('electrical_evaluations_ot_id_foreign');
        });
        Schema::table('eval_electrical_characteristics', function (Blueprint $table) {
            $table->dropForeign('eval_electrical_characteristics_eel_id_foreign');
        });
        Schema::table('eval_electrical_reception', function (Blueprint $table) {
            $table->dropForeign('eval_electrical_reception_eel_id_foreign');
        });
        Schema::table('eval_electrical_test_in', function (Blueprint $table) {
            $table->dropForeign('eval_electrical_test_in_eel_id_foreign');
        });
        Schema::table('eval_electrical_transformer', function (Blueprint $table) {
            $table->dropForeign('eval_electrical_transformer_eel_id_foreign');
        });
        Schema::table('electrical_evaluation_works', function (Blueprint $table) {
            $table->dropForeign('electrical_evaluation_works_me_id_foreign');
            $table->dropForeign('electrical_evaluation_works_service_id_foreign');
        });

        Schema::dropIfExists('eval_electrical_characteristics');
        Schema::dropIfExists('eval_electrical_reception');
        Schema::dropIfExists('eval_electrical_test_in');
        Schema::dropIfExists('eval_electrical_transformer');
        Schema::dropIfExists('electrical_evaluations');
        Schema::dropIfExists('electrical_evaluation_works');
    }
}
