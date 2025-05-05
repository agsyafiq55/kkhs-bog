<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeImageColumnsToString extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->change();
        });

        Schema::table('gallery', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });

        Schema::table('aboutus', function (Blueprint $table) {
            $table->string('organization_photo')->nullable()->change();
            $table->string('chairman_photo')->nullable()->change();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->string('photo')->nullable()->change();
        });
    }

    public function down()
    {
        // Optional: revert to longtext if needed
    }
}
;
