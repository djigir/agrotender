<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAddFieldsTableUsers2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('users2', 'auth_users_laravel');
        Schema::table('auth_users_laravel', function (Blueprint $table){
            $table->string('new_password')->charset('')->change()->nullable();
            $table->integer('isactive_ban')->charset('')->change()->nullable();
            $table->integer('discount_level_id')->charset('')->change()->nullable();
            $table->integer('avail_adv_posts')->charset('')->change()->nullable();
            $table->integer('max_adv_posts')->charset('')->change()->nullable();
            $table->integer('max_fishka')->charset('')->change()->nullable();
            $table->integer('city_id')->charset('')->change()->nullable();
            $table->integer('obl_id')->charset('')->change()->nullable();
            $table->integer('ray_id')->charset('')->change()->nullable();
            $table->integer('rate')->charset('')->change()->nullable();
            $table->integer('postdone')->charset('')->change()->nullable();
            $table->integer('smschecked')->charset('')->change()->nullable();
            $table->dateTime('add_date')->nullable();
            $table->dateTime('last_login')->charset('')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('auth_users_laravel', 'users2');
        Schema::table('auth_users_laravel', function (Blueprint $table) {
            $table->dropColumn(['add_date']);
        });
    }
}
