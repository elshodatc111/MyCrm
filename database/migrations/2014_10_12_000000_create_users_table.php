<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('filial', 11);
            $table->string('name', 70);
            $table->string('address', 70);
            $table->string('phone', 20);
            $table->string('tkun');
            $table->string('type', 10);
            $table->string('status', 10);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void{
        Schema::dropIfExists('users');
    }
};
