<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->string('seat_number'); // A1, A2, B1, etc.
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->timestamps();
            
            // Unique combination of show and seat
            $table->unique(['show_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
