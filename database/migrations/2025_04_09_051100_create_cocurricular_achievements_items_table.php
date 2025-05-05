<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('cocurricular_achievements_items')) {
            Schema::create('cocurricular_achievements_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cocurricular_achievement_id')->constrained()->onDelete('cascade');
                $table->string('achievement');
                $table->integer('student_count')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('cocurricular_achievements_items');
    }
};