<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToOtGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('eval_type');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropForeign('ot_gallery_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
