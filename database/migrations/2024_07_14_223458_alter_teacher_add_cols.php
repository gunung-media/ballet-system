<?php

use App\Enums\EmployeeTypeEnum;
use App\Utils\EnumUtils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->enum('type', EnumUtils::toArray(EmployeeTypeEnum::class))->default(EmployeeTypeEnum::teacher);
            $table->string('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('password');
        });
    }
};
