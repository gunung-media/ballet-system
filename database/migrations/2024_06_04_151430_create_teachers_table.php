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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('identity_number');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->date('birth_date');
            $table->date('join_date');
            $table->enum('status', ['Active', 'Vacation', 'Resign'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
