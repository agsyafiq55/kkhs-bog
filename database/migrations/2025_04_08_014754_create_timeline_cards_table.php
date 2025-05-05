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
        Schema::create('timeline_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('description_zh')->nullable(); // Chinese description
            $table->integer('position')->default(0); // For ordering
            $table->string('side')->default('left'); // 'left' or 'right'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_cards');
    }
};
