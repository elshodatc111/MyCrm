<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_edet', 5)->default('off');
            $table->string('user_delete', 5)->default('off');
            $table->string('guruh_edet', 5)->default('off');
            $table->string('guruh_delete', 5)->default('off');
            $table->string('hisobotlar', 5)->default('off');
            $table->string('statistika', 5)->default('off');
            $table->string('moliya', 5)->default('off');
            $table->string('moliya_tasdiqlash', 5)->default('off');
            $table->string('techer', 5)->default('off');
            $table->string('techer_edit', 5)->default('off');
            $table->string('techer_delete', 5)->default('off');
            $table->string('hodim', 5)->default('off');
            $table->string('hodim_edit', 5)->default('off');
            $table->string('hodim_delete', 5)->default('off');
            $table->string('xonalar', 5)->default('off');
            $table->string('xonalar_edet', 5)->default('off');
            $table->string('xonalar_delete', 5)->default('off');
            $table->string('mening_balansim', 5)->default('off');
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('admins');
    }
};
