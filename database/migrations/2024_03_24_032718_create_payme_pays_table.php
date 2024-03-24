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
        Schema::create('payme_pays', function (Blueprint $table) {
            $table->id();
            $table->integer('tulov_id');
            $table->integer('history_id');
            $table->integer('chegirma_id');
            $table->integer('transaction_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payme_pays');
    }
};
