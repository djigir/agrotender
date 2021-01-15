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
        Schema::connection('mysql_not_prefix')->rename('regions', 'agt_regions');
        Schema::connection('mysql_not_prefix')->rename('traders_feed', 'agt_traders_feed');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_not_prefix')->rename('agt_regions', 'regions');
        Schema::connection('mysql_not_prefix')->rename('agt_traders_feed', 'traders_feed');
    }
}
