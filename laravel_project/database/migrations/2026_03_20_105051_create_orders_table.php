<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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

        // Customer Details
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('customer_email')->nullable();
        $table->string('customer_address');

        // Payment
        $table->string('payment_method');  // COD / Online
        $table->string('note')->nullable();

        // Order Info
        $table->decimal('grand_total', 10, 2)->default(0);
        $table->string('status')->default('Pending');  

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
        Schema::dropIfExists('orders');
    }
};
