<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_gallery', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ot_id')->nullable();
            $table->foreign('ot_id')->references('id')->on('ots');

            $table->string('eval_type');
            $table->string('name');
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
        Schema::table('ot_gallery', function (Blueprint $table) {
            $table->dropForeign('ot_gallery_ot_id_foreign');
        });
        Schema::dropIfExists('ot_gallery');
    }
}
