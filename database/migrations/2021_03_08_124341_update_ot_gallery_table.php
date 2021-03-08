<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOtGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('work_id')->nullable()->after('eval_type');
            $table->foreign('work_id')->references('id')->on('ot_works')->onDelete('cascade');
            $table->string('file')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_gallery', function (Blueprint $table) {
            $table->dropColumn('work_id');
        });
    }
}
