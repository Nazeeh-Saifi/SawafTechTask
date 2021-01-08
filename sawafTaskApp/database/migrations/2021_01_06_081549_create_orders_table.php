<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->dateTime("OrderDate");
            $table->string("OrderNumber",10);
            $table->unsignedBigInteger("CustomerId");
            $table->decimal("TotalAmount",$precision = 12, $scale = 2);
            $table->foreign("CustomerId")->references("id")->on("customers")->onDelete("cascade");
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
