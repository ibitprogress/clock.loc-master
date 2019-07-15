<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmedCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmed_carts', function (Blueprint $table) {
            $table->increments('confirmed_cart_id');
            $table->integer('order_id')
                ->references('orders_id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('clock_id')
                ->references('clock_id')->on('clocks')
                ->onUpdate('cascade');
            $table->integer('qty');
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
        Schema::dropIfExists('confirmed_carts');
    }
}
