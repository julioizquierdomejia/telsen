<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdi_maintenance_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('enabled')->default(1);

            $table->timestamps();
        });

        //Criticidad
        Schema::create('rdi_criticality_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('enabled')->default(1);

            $table->timestamps();
        });

        Schema::create('rdi', function (Blueprint $table) {
            $table->id();
            $table->string('rdi_codigo');
            $table->string('version');

            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->string('contact')->nullable();
            $table->string('area')->nullable();
            $table->string('equipo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('ot')->nullable();
            $table->date('fecha_ingreso');
            $table->date('tiempo_entrega');
            $table->string('orden_servicio')->nullable();

            $table->bigInteger('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('motor_brands');

            $table->string('nro_serie')->nullable();
            $table->string('frame')->nullable();
            $table->string('potencia')->nullable();
            $table->string('tension')->nullable();
            $table->string('corriente')->nullable();
            $table->string('velocidad')->nullable();
            $table->string('conexion')->nullable();
            $table->string('deflexion_eje')->nullable();
            $table->string('rodaje_delantero')->nullable();
            $table->string('rodaje_posterior')->nullable();
            $table->text('antecedentes')->nullable();

            $table->string('hecho_por')->nullable();
            $table->float('cost');

            $table->text('diagnostico_actual');

            $table->string('aislamiento_masa_ingreso');

            $table->bigInteger('rdi_maintenance_type_id')->unsigned();
            $table->foreign('rdi_maintenance_type_id')->references('id')->on('rdi_maintenance_types');

            $table->bigInteger('rdi_criticality_type_id')->unsigned();
            $table->foreign('rdi_criticality_type_id')->references('id')->on('rdi_criticality_types');

            $table->boolean('enabled')->default(1);

            $table->timestamps();
        });

        Schema::create('rdi_ingresos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rdi_id')->unsigned();
            $table->foreign('rdi_id')->references('id')->on('rdi');
            $table->boolean('placa_caracteristicas');
            $table->boolean('caja_conexion');
            $table->boolean('bornera');
            $table->boolean('escudos');
            $table->boolean('ejes');
            $table->boolean('funda');
            $table->boolean('ventilador');
            $table->boolean('acople');
            $table->boolean('chaveta');
            $table->timestamps();
        });

        Schema::create('rdi_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('enabled')->default(1);

            $table->timestamps();
        });

        Schema::create('rdi_service_costs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('rdi_id')->unsigned();
            $table->foreign('rdi_id')->references('id')->on('rdi');

            $table->unsignedBigInteger('rdi_service_id');
            $table->foreign('rdi_service_id')->references('id')->on('rdi_services');
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
        Schema::table('rdi', function (Blueprint $table) {
            $table->dropForeign('rdi_client_id_foreign');
            $table->dropForeign('rdi_marca_id_foreign');
            $table->dropForeign('rdi_rdi_maintenance_type_id_foreign');
            $table->dropForeign('rdi_rdi_criticality_type_id_foreign');
        });
        Schema::table('rdi_ingresos', function (Blueprint $table) {
            $table->dropForeign('rdi_ingresos_rdi_id_foreign');
        });
        Schema::table('rdi_service_costs', function (Blueprint $table) {
            $table->dropForeign('rdi_service_costs_rdi_id_foreign');
            $table->dropForeign('rdi_service_costs_rdi_service_id_foreign');
        });
        Schema::dropIfExists('rdi_maintenance_types');
        Schema::dropIfExists('rdi_criticality_types');
        Schema::dropIfExists('rdi_ingresos');
        Schema::dropIfExists('rdi_services');
        Schema::dropIfExists('rdi_service_costs');
        Schema::dropIfExists('rdi');
    }
}
