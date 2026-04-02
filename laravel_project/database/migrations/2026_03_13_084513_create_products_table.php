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
    Schema::create('products', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('cate_id');

        $table->foreign('cate_id')
              ->references('id')
              ->on('categorys') // 🔥 FIXED (categories → categorys)
              ->onDelete('cascade');
        $table->string('name');
        $table->string('image');
        $table->string('price');
        $table->string('description');
        $table->string('brand');
        $table->enum('status',['Block','Unblock'])->default('Unblock');
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
        Schema::dropIfExists('products');
    }
};
