<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the products table with columns: name, price, stock_count
     * as required by the assessment, plus additional fields for the mini project.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Product name (required)
            $table->text('description')->nullable();         // Product description
            $table->decimal('price', 10, 2);                 // Product price (required)
            $table->integer('stock_count')->default(0);      // Stock quantity
            $table->string('image')->nullable();             // Product thumbnail image path
            $table->foreignId('category_id')                 // Foreign key to categories
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            $table->foreignId('user_id')                     // Foreign key to users (creator)
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
