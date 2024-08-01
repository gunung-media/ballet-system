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
        Schema::table('employee_absences', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropForeign(['employee_id']);

            $table->unsignedBigInteger('teacher_id');

            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_absences', function (Blueprint $table) {
            $table->enum('state', EnumUtils::toArray(AbsenceStateEnum::class))->default(AbsenceStateEnum::hadir->value);
            $table->dropColumn('check_in');
            $table->dropColumn('check_out');
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }
};
