<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academic_achievement_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_achievement_id')->constrained()->onDelete('cascade');
            $table->string('grade'); // e.g., "10A", "9A", etc.
            $table->integer('student_count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_achievement_grades');
    }
};