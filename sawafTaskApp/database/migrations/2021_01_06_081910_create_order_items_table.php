<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("OrderId");
            $table->unsignedBigInteger("ProductId");
            $table->decimal("UnitPrice",$precision = 12, $scale = 2);
            $table->integer("Quantity");
            $table->foreign("OrderId")->references("id")->on("orders")->onDelete("cascade");
            $table->foreign("ProductId")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
