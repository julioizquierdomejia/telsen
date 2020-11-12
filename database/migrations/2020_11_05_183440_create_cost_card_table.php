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
        Schema::create('cost_cards', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            /*$table->string('solped');
            $table->string('equipo');
            $table->string('codigo');
            $table->string('hecho_por');
            $table->string('hp_kw');
            $table->string('placa');*/
            $table->string('hecho_por');
            $table->string('cotizacion')->nullable();
            $table->float('cost');
            $table->float('cost_m1');
            $table->float('cost_m2');
            $table->float('cost_m3');
            $table->boolean('enabled');

            $table->timestamps();
        });

        Schema::create('cost_card_services', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cost_card_id');
            $table->foreign('cost_card_id')->references('id')->on('cost_cards');

            $table->bigInteger('area_id')->nullable()->unsigned();
            $table->index('area_id')->nullable();
            $table->foreign('area_id')->nullable()->references('id')->on('areas')->onDelete('cascade');

            /*$table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');*/
            $table->bigInteger('service_id')->nullable()->unsigned();
            $table->index('service_id')->nullable();
            $table->foreign('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');

            $table->string('personal');
            $table->string('ingreso');
            $table->string('salida');
            $table->float('subtotal');

            $table->timestamps();
        });

        /*Schema::create('cost_card_service_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cost_card_services_id');
            $table->foreign('cost_card_services_id')->references('id')->on('service_cost_card');

            $table->string('personal');
            $table->string('ingreso');
            $table->string('salida');
            $table->float('subtotal');

            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cost_cards', function (Blueprint $table) {
            $table->dropForeign('cost_cards_ot_id_foreign');
        });
        Schema::table('cost_card_services', function (Blueprint $table) {
            $table->dropForeign('cost_card_services_cost_card_id_foreign');
            $table->dropForeign('cost_card_services_area_id_foreign');
            $table->dropForeign('cost_card_services_service_id_foreign');
        });
        /*Schema::table('cost_card_services_details', function (Blueprint $table) {
            $table->dropForeign('cost_card_services_cost_card_services_id_foreign');
        });*/
        Schema::dropIfExists('cost_cards');
        Schema::dropIfExists('cost_card_services');
        //Schema::dropIfExists('cost_card_service_details');
    }
}
