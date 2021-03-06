<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricalGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_gallery', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('el_id');
            $table->foreign('el_id')->references('id')->on('electrical_evaluations');
            
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
        Schema::table('electrical_gallery', function (Blueprint $table) {
            $table->dropForeign('electrical_gallery_el_id_foreign');
        });
        Schema::dropIfExists('electrical_gallery');
    }
}
