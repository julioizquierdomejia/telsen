<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_card', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            /*$table->string('solped');
            $table->string('equipo');
            $table->string('codigo');
            $table->string('hecho_por');
            $table->string('hp_kw');
            $table->string('placa');*/
            $table->boolean('enabled');

            $table->timestamps();
        });

        Schema::create('service_cost_card', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cost_card_id');
            $table->foreign('cost_card_id')->references('id')->on('cost_card');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->timestamps();
        });

        Schema::create('service_cost_card_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_cost_card_id');
            $table->foreign('service_cost_card_id')->references('id')->on('service_cost_card');

            $table->string('personal');
            $table->string('ingreso');
            $table->string('salida');
            $table->float('subtotal');

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
        Schema::table('cost_card', function (Blueprint $table) {
            $table->dropForeign('cost_card_ot_id_foreign');
        });
        Schema::table('service_cost_card', function (Blueprint $table) {
            $table->dropForeign('service_cost_card_ot_id_foreign');
            $table->dropForeign('service_cost_card_service_id_foreign');
        });
        Schema::table('service_cost_card_details', function (Blueprint $table) {
            $table->dropForeign('service_cost_card_service_cost_card_id_foreign');
        });
        Schema::dropIfExists('cost_card');
        Schema::dropIfExists('service_cost_card');
        Schema::dropIfExists('service_cost_card_details');
    }
}
