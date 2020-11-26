<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auth_users_laravel', function (Blueprint $table){
            /*$table->increments('id')->change();
            $table->unsignedInteger('id')->change();
            $table->primary('id');
            $table->integer('user_id');*/
            $table->renameColumn('id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_users_laravel', function (Blueprint $table) {
//            $table->integer('user_id');
            $table->renameColumn('user_id', 'id');
        });
    }
}
