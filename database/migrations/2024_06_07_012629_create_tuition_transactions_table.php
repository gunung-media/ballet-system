<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\StudioTypeEnum;
use App\Enums\TuitionTypeEnum;
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
        Schema::create('tuition_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('student_name')->nullable();
            $table->date('for_month')->nullable();
            $table->unsignedBigInteger('amount');
            $table->string('note')->nullable();
            $table->enum('tuition_type', EnumUtils::toArray(TuitionTypeEnum::class))->default(TuitionTypeEnum::spp);
            $table->enum('discount_type', EnumUtils::toArray(DiscountTypeEnum::class))->nullable();
            $table->enum('studio_type', EnumUtils::toArray(StudioTypeEnum::class))->nullable();
            $table->integer('discount')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_transactions');
    }
};
