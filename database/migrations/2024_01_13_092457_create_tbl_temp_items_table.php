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
        Schema::create('tbl_temp_items', function (Blueprint $table) {
            $table->id();
            $table->string('purchaseId');
            $table->string('itemId');
            $table->string('name');
            $table->string('unit');
            $table->string('type');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_temp_items');
    }
};
