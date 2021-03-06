<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
        });

        Schema::create('status_ot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status');

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
        Schema::table('status', function (Blueprint $table) {
            $table->dropUnique('status_name_unique');
        });
        Schema::table('status_ot', function (Blueprint $table) {
            $table->dropForeign('status_ot_ot_id_foreign');
            $table->dropForeign('status_ot_status_id_foreign');
        });

        Schema::dropIfExists('status');
        Schema::dropIfExists('status_ot');
    }
}
