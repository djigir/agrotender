<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users_laravel', function (Blueprint $table) {
            $table->integer('id');
            $table->string('login');
            $table->string('passwd');
            $table->string('new_password')->nullable();
            $table->string('isactive')->nullable();
            $table->string('isactive_web')->nullable();
            $table->integer('isactive_ban')->nullable();
            $table->integer('discount_level_id')->nullable();
            $table->string('add_date')->nullable();
            $table->string('last_login')->nullable();
            $table->integer('avail_adv_posts')->nullable();
            $table->integer('max_adv_posts')->nullable();
            $table->integer('max_fishka')->nullable();
            $table->string('name')->nullable();
            $table->string('name2')->nullable();
            $table->string('name3')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('obl_id')->nullable();
            $table->integer('ray_id')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('postdone')->nullable();
            $table->string('orgname')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('newphone')->nullable();
            $table->string('email')->nullable();
            $table->string('icq')->nullable();
            $table->string('telegram')->nullable();
            $table->string('guid_deact')->nullable();
            $table->string('viber')->nullable();
            $table->string('last_visit_url')->nullable();
            $table->string('guid_act')->nullable();
            $table->string('skype')->nullable();
            $table->string('comments')->nullable();
            $table->integer('smschecked')->nullable();
            $table->string('deact_up_mails')->nullable();
            $table->string('subscr_adv_deact')->nullable();
            $table->string('subscr_adv_up')->nullable();
            $table->string('subscr_tr_price')->nullable();
            $table->string('old_login')->nullable();
            $table->string('new_login')->nullable();
            $table->string('new_login_guid')->nullable();
            $table->string('last_ip')->nullable();
            $table->string('hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_users_laravel');
    }
}
