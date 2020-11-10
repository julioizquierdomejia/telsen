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
            $table->string('area');
            $table->string('equipo');
            $table->string('codigo');
            $table->string('ot');
            $table->date('fecha_ingreso');
            $table->date('tiempo_entrega');
            $table->date('orden_servicio');

            $table->bigInteger('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('motor_brands');

            $table->string('nro_serie');
            $table->string('frame');
            $table->string('potencia');
            $table->string('tension');
            $table->string('corriente');
            $table->string('velocidad');
            $table->string('conexion');
            $table->string('deflexion_eje');
            $table->string('rodaje_delantero');
            $table->string('rodaje_posterior');
            $table->text('antecedentes');

            $table->string('hecho_por');
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

        Schema::create('rdi_ingreso', function (Blueprint $table) {
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
            $table->boolean('enabled')->default(1);
            $table->timestamps();
        });

        Schema::create('rdi_services', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rdi_id');
            $table->foreign('rdi_id')->references('id')->on('rdis');

            $table->string('name');
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
            $table->dropForeign('rdi_rdi_maintenance_type_id_foreign');
            $table->dropForeign('rdi_client_id_foreign');
            $table->dropForeign('rdi_marca_id_foreign');
            $table->dropForeign('rdi_rdi_criticality_type_id_foreign');
        });
        Schema::table('rdi_ingreso', function (Blueprint $table) {
            $table->dropForeign('rdi_rdi_id_foreign');
        });
        Schema::table('rdi_services', function (Blueprint $table) {
            $table->dropForeign('rdi_rdi_rdi_id_foreign');
        });
        Schema::dropIfExists('rdi_maintenance_types');
        Schema::dropIfExists('rdi_criticality_types');
        Schema::dropIfExists('rdi_ingreso');
        Schema::dropIfExists('rdi_services');
        Schema::dropIfExists('rdi');
    }
}
