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
    Schema::create('categorys', function (Blueprint $table) {

        $table->engine = 'InnoDB';   // 🔥 IMPORTANT LINE

        $table->id();
        $table->string('name');
        $table->string('image')->nullable();
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
        Schema::dropIfExists('categorys');
    }
};
