<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();   // username for login
            $table->string('password');             // hashed password
            $table->rememberToken();                // for "remember me"
            $table->timestamps();                   // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};