<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('balans', function (Blueprint $table) {
            $table->id();
            $table->integer('filial_id')->nullable();
            $table->integer('summa')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->integer('start_admin')->nullable();
            $table->integer('end_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('balans');
    }
};
