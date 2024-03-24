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
        Schema::create('xarajats', function (Blueprint $table) {
            $table->id();
            $table->integer('filial_id');
            $table->integer('summa');
            $table->string('comment');
            $table->string('type');
            $table->string('operator_id');
            $table->string('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xarajats');
    }
};
