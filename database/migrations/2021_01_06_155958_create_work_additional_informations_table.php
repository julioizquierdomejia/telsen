<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkAdditionalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_additional_informations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('public')->default(1);
            $table->timestamps();
        });

        Schema::create('work_additional_information_cols', function (Blueprint $table) {
            $table->id();

            $table->string('table_id');

            $table->unsignedBigInteger('work_add_in_id');
            $table->foreign('work_add_in_id')->references('id')->on('work_additional_informations');

            $table->string('col_name');
            $table->string('col_type');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->timestamps();
        });

        Schema::create('work_additional_information_data', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('col_id');
            $table->foreign('col_id')->references('id')->on('work_additional_information_cols');

            $table->unsignedBigInteger('ot_work_id');
            $table->foreign('ot_work_id')->references('id')->on('ot_works');

            $table->string('content')->nullable();

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
        Schema::table('work_additional_information_cols', function (Blueprint $table) {
            $table->dropForeign('work_additional_information_cols_table_id_foreign');
            $table->dropForeign('work_additional_information_cols_service_id_foreign');
        });
        Schema::table('work_additional_information_data', function (Blueprint $table) {
            $table->dropForeign('work_additional_information_data_col_id_foreign');
            $table->dropForeign('work_additional_information_data_ot_work_id_foreign');
        });
        Schema::dropIfExists('work_additional_informations');
        Schema::dropIfExists('work_additional_information_cols');
        Schema::dropIfExists('work_additional_information_data');
    }
}
