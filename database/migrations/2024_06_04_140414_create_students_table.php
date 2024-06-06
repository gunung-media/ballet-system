<?php

use App\Enums\GenderEnum;
use App\Utils\EnumUtils;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', EnumUtils::toArray(GenderEnum::class));
            $table->date('birth_date');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('photo')->nullable();
            $table->string('wali_name');
            $table->string('wali_phone');
            $table->date('registration');
            $table->string('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
