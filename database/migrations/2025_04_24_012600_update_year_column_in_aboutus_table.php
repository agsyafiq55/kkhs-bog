<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('aboutus', function (Blueprint $table) {
            $table->string('year', 9)->change(); // Format: "YYYY-YYYY"
        });
    }

    public function down()
    {
        Schema::table('aboutus', function (Blueprint $table) {
            $table->year('year')->change();
        });
    }
};