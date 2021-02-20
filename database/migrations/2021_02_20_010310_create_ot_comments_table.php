<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ot_id');
            $table->foreign('ot_id')->references('id')->on('ots');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('comment');

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
        Schema::table('ot_comments', function (Blueprint $table) {
            $table->dropForeign('ot_comments_ot_id_foreign');
            $table->dropForeign('ot_comments_user_id_foreign');
        });

        Schema::dropIfExists('ot_comments');
    }
}
