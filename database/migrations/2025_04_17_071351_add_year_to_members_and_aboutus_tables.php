<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->year('year')->after('id');
        });

        Schema::table('aboutus', function (Blueprint $table) {
            $table->year('year')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('year');
        });

        Schema::table('aboutus', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }

};
