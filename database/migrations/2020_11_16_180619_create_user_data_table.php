<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->timestamps();
        });

        Schema::create('user_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');

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
        Schema::table('user_data', function (Blueprint $table) {
            $table->dropForeign('user_data_user_id_foreign');
        });
        Schema::table('user_area', function (Blueprint $table) {
            $table->dropForeign('user_area_user_id_foreign');
            $table->dropForeign('user_area_area_id_foreign');
        });
        Schema::dropIfExists('user_data');
        Schema::dropIfExists('user_area');
    }
}
