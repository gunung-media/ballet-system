<?php

use App\Enums\DayEnum;
use App\Utils\EnumUtils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('day', EnumUtils::toArray(DayEnum::class));
            $table->time('time');
            $table->float('duration');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();

            $table->foreign('class_id')->on('classes')->references('id')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
