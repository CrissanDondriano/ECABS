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
        Schema::create('tbl_staff_schedules', function (Blueprint $table) {
            $table->id();
            $table->string("staffId");
            $table->string("staffReason");
            $table->datetime("startDate");
            $table->datetime("endDate");
            $table->string("availability");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_staff_schedules');
    }
};
