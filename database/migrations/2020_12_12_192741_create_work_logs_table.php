<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkLogsTable extends Migration
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
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('work_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id');
            $table->foreign('work_id')->references('id')->on('ot_works')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->string('type');
            //$table->string('description')->nullable();

            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('work_status')->onDelete('cascade');

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
        Schema::table('work_logs', function (Blueprint $table) {
            $table->dropForeign('work_logs_work_id_foreign');
            $table->dropForeign('work_logs_user_id_foreign');
            $table->dropForeign('work_logs_status_id_foreign');
        });
        Schema::dropIfExists('work_status');
        Schema::dropIfExists('work_logs');
    }
}
