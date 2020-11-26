<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRegionAndTradersFeedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('regions', 'agt_regions');
        Schema::rename('traders_feed', 'agt_traders_feed');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('agt_regions', 'regions');
        Schema::rename('agt_traders_feed', 'traders_feed');
    }
}
