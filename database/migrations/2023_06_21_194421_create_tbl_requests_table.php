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
        Schema::create('tbl_requests', function (Blueprint $table) {
            $table->id();
            $table->string('purpose');
            $table->string('items');
            $table->string('purpose2');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_requests');

        Schema::table('tbl_requests', function (Blueprint $table) {
            $table->dropColumn('items');
        });
    }
};
