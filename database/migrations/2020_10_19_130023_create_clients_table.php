<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('ruc');
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('contacto')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('correo')->nullable();
            $table->string('info')->nullable();

            $table->unsignedBigInteger('client_type_id');
            $table->foreign('client_type_id')->references('id')->on('client_types');

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
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('client_types_client_type_id_foreign');
        });
        Schema::dropIfExists('clients');
    }
}
