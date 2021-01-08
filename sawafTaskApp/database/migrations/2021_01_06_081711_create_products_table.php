<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("ProductName",50);
            $table->unsignedBigInteger("SupplierId");
            $table->decimal("UnitPrice",$precision = 12, $scale = 2);
            $table->foreign("SupplierId")->references("id")->on("suppliers")->onDelete("cascade");      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
