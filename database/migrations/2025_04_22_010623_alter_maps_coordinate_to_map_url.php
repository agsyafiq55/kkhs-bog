<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMapsCoordinateToMapUrl extends Migration
{
    public function up()
    {
        Schema::table('contact_us', function (Blueprint $table) {
            $table->renameColumn('maps_coordinate', 'map_url');
            $table->text('map_url')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('contact_us', function (Blueprint $table) {
            $table->renameColumn('map_url', 'maps_coordinate');
            $table->string('maps_coordinate')->nullable()->change();
        });
    }
}