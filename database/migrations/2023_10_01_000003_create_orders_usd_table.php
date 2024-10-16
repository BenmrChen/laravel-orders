<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersUsdTable extends Migration
{
    public function up()
    {
        Schema::create('orders_usd', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('address_id')->constrained();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_usd');
    }
}
