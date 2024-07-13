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
        Schema::create('tbl_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('recipientId');
            $table->string('recipientName');
            $table->string('organization');
            $table->string('contact_number');
            $table->string('address');
            $table->string('facility');
            $table->string('date');
            $table->string('time');
            $table->string('status');
            $table->string('activity');
            $table->string('equipment_needed');
            $table->integer('people');
            $table->string('event_type');
            $table->binary('attachment');
            $table->string('staff');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reservations');
    }
};
