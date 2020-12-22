<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtWorkStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ot_work_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_status_id');
            $table->foreign('work_status_id')->references('id')->on('work_status');
            $table->unsignedBigInteger('ot_work_id');
            $table->foreign('ot_work_id')->references('id')->on('ot_works');

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
        Schema::table('ot_work_status', function (Blueprint $table) {
            $table->dropForeign('ot_work_status_work_status_id_foreign');
            $table->dropForeign('ot_work_status_ot_work_id_foreign');
        });
        Schema::dropIfExists('work_status');
        Schema::dropIfExists('ot_work_status');
    }
}
