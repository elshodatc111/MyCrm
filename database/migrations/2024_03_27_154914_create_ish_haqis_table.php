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
        Schema::create('ish_haqis', function (Blueprint $table) {
            $table->id();
            $table->integer('filial_id');
            $table->integer('user_id');
            $table->string('status');
            $table->integer('summa');
            $table->string('type');
            $table->string('commit');
            $table->integer('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ish_haqis');
    }
};
