<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->increments('description_id');
            $table->string('description_name');
            $table->integer('clock_id')
                ->references('clock_id')->on('clocks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('value_uk')->nullable();
            $table->text('value_ru')->nullable();
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
        Schema::dropIfExists('descriptions');
    }
}
