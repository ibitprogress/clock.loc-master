<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClockImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clock_images', function (Blueprint $table) {
            $table->increments('image_id');
            $table->integer('clock_id')
                  ->references('clock_id')->on('clocks')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('uuid');
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
        Schema::dropIfExists('clock_images');
    }
}
