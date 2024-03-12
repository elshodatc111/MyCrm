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
        Schema::create('eslatmas', function (Blueprint $table) {
            $table->id();
            $table->string('filial_id');
            $table->integer('admin_id');
            $table->string('type');
            $table->string('status');
            $table->string('text');
            $table->string('user_guruh_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eslatmas');
    }
};
