<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('cocurricular_achievements')) {
            Schema::create('cocurricular_achievements', function (Blueprint $table) {
                $table->id();
                $table->string('event_title');
                $table->string('category'); // Robotics, Sports, Debate, etc.
                $table->date('event_date');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cocurricular_achievements');
    }
};