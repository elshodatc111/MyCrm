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
        Schema::create('kassas', function (Blueprint $table) {
            $table->id();
            $table->integer('filial_id')->nullable();
            $table->integer('ChiqimNaqt')->nullable();
            $table->integer('ChiqimPlastik')->nullable();
            $table->integer('XarajatNaqt')->nullable();
            $table->integer('XarajatPlastik')->nullable();
            $table->integer('HodimPayNaqt')->nullable();
            $table->integer('HodimPayPlastik')->nullable();
            $table->integer('TecherPayNaqt')->nullable();
            $table->integer('TecherPayPlastik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kassas');
    }
};
