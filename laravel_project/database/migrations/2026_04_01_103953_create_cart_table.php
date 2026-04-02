<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();

            // user id (optional agar login system hai)
            $table->unsignedBigInteger('user_id')->nullable();

            // product table se relation
            $table->unsignedBigInteger('product_id');

            // quantity
            $table->integer('qty')->default(1);

            // price of single product
            $table->decimal('price', 10, 2);

            // total price (qty * price)
            $table->decimal('total_price', 10, 2);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart');
    }
};