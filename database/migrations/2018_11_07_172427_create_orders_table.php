<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('client_first_name');
            $table->string('client_last_name');
            $table->integer('phone');
            $table->text('city')->nullable();
            $table->text('warehous')->nullable();
            $table->string('delivery_method');
            $table->string('pay_method');
            $table->integer('total_price');
            $table->boolean('revised');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
