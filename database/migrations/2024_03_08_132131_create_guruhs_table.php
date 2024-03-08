<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('guruhs', function (Blueprint $table) {
            $table->id();
            $table->integer('filial');
            $table->string('guruh_name');
            $table->integer('test_id');
            $table->integer('room_id');
            $table->string('guruh_juft_toq');
            $table->string('guruh_dars_vaqt');
            $table->string('guruh_start');
            $table->string('guruh_end');
            $table->integer('guruh_price');
            $table->integer('guruh_chegirma');
            $table->integer('guruh_chegirma_day');
            $table->integer('techer_id');
            $table->integer('techer_tulov');
            $table->integer('techer_bonus');
            $table->integer('admin_id');
            $table->integer('admin_chegirma');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guruhs');
    }
};
