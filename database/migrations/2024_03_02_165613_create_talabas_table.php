<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('talabas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('Tanish', 70)->default('NULL');
            $table->string('TanishPhone', 100)->default('NULL');
            $table->string('BizHaqimizda', 100)->default('NULL');
            $table->string('TalabaHaqida', 100)->default('NULL');
            $table->timestamps();
        });
    }
    
    public function down(): void{
        Schema::dropIfExists('talabas');
    }
};
