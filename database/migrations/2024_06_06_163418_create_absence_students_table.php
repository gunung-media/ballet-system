<?php

use App\Enums\AbsenceStateEnum;
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
        Schema::create('absence_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_id');
            $table->unsignedBigInteger('student_id');
            $table->enum('state', EnumUtils::toArray(AbsenceStateEnum::class));
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('absence_id')->references('id')->on('absences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_students');
    }
};
