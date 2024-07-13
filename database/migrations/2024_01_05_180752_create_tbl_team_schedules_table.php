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
        Schema::create('tbl_team_schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reason');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('availability');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_team_schedules');
    }
};
