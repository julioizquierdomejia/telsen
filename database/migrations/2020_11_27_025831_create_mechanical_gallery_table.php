<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMechanicalGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanical_gallery', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('me_id');
            $table->foreign('me_id')->references('id')->on('mechanical_evaluations');

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
        Schema::table('mechanical_gallery', function (Blueprint $table) {
            $table->dropForeign('mechanical_gallery_me_id_foreign');
        });
        Schema::dropIfExists('mechanical_gallery');
    }
}
