<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_works', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->string('type')->nullable(); //electrica, mecanica, rdi

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
        Schema::table('ot_works', function (Blueprint $table) {
            $table->dropForeign('ot_works_ot_id_foreign');
            $table->dropForeign('ot_works_service_id_foreign');
        });
        Schema::dropIfExists('ot_works');
    }
}
