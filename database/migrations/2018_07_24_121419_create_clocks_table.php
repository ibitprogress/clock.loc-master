<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clocks', function (Blueprint $table) {
            $table->increments('clock_id');
            $table->string('name');
            $table->string('gender');
            $table->string('type_of_indexation');
            $table->string('type_of_mechanism');
            $table->string('producer');
            $table->integer('price');
            $table->integer('old_price');
            $table->string('availability');
            $table->boolean('hide');
            $table->string('logo_uuid')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE clocks AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clocks');
    }
}
