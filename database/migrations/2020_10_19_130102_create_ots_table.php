<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ots', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            //$table->date('fecha_creacion');
            $table->string('guia_cliente')->nullable();
            $table->string('solped')->nullable();
            $table->string('descripcion_motor')->nullable();
            $table->string('codigo_motor')->nullable();
            
            $table->unsignedInteger('marca_id')->nullable();
            //$table->index('marca_id')->nullable();

            $table->unsignedInteger('modelo_id')->nullable();
            //$table->index('modelo_id')->nullable();

            $table->string('numero_potencia')->nullable();
            $table->string('medida_potencia')->nullable();
            $table->string('voltaje')->nullable();
            $table->string('velocidad')->nullable();
            $table->boolean('enabled')->default(1);

            $table->timestamps();
        });

        Schema::table('ots', function($table) {
            $table->foreign('marca_id')->references('id')->on('motor_brands');
            $table->foreign('modelo_id')->references('id')->on('motor_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ots', function (Blueprint $table) {
            $table->dropForeign('ots_client_id_foreign');
            $table->dropForeign('ots_marca_id_foreign');
            $table->dropForeign('ots_modelo_id_foreign');
        });

        Schema::dropIfExists('ots');
    }
}
