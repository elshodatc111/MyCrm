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
        Schema::create('guruh_users', function (Blueprint $table) {
            $table->id();
            $table->integer('guruh_id');
            $table->integer('user_id');
            $table->string('start_data');
            $table->string('start_commit');
            $table->string('start_meneger');
            $table->string('status');
            $table->string('end_data');
            $table->string('end_commit');
            $table->string('end_meneger');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guruh_users');
    }
};
