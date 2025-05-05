<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('academic_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('exam_type'); // SPM or STPM
            $table->year('year');
            $table->decimal('gps', 4, 2); // Grade Point Score (e.g., 4.46)
            $table->decimal('certificate_percentage', 5, 2); // Certificate Qualification Percentage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_achievements');
    }
};