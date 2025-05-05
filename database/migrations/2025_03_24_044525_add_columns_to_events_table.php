<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('article')->after('description'); 
            $table->string('thumbnail')->nullable()->after('event_date'); 
            $table->string('tag')->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['article', 'thumbnail', 'tag']);
        });
    }
};
