<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClockFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clock_functions', function (Blueprint $table) {
            $table->increments('function_id');
            $table->integer('clock_id')
                  ->references('clock_id')->on('clocks')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('value_uk')->nullable();
            $table->string('value_ru')->nullable();
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
        Schema::dropIfExists('clock_functions');
    }
}
