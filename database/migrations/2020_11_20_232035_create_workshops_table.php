<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            
            /*$table->bigInteger('ot_id')->unsigned();
            $table->foreign('ot_id')->references('id')->on('ots');*/

            /*$table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');*/
            $table->bigInteger('ot_work_id')->unsigned();
            $table->foreign('ot_work_id')->references('id')->on('ot_works');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::table('workshops', function (Blueprint $table) {
            //$table->dropForeign('workshops_ot_id_foreign');
            //$table->dropForeign('workshops_service_id_foreign');
            $table->dropForeign('workshops_ot_work_id_foreign');
            $table->dropForeign('workshops_user_id_foreign');
        });
        Schema::dropIfExists('workshops');
    }
}
