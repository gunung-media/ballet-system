<?php

use App\Enums\GenderEnum;
use App\Enums\TeacherStatus;
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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('identity_number');
            $table->enum('gender', EnumUtils::toArray(GenderEnum::class));
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date');
            $table->date('join_date')->nullable();
            $table->enum('status', EnumUtils::toArray(TeacherStatus::class))->default('Active')->nullable();
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
