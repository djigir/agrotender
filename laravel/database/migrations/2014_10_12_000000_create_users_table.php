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
            $table->timestamp('new_password')->nullable();
            $table->string('isactive')->nullable();
            $table->string('isactive_web')->nullable();
            $table->string('isactive_ban')->nullable();
            $table->string('discount_level_id')->nullable();
            $table->string('last_login')->nullable();
            $table->string('avail_adv_posts')->nullable();
            $table->string('max_adv_posts')->nullable();
            $table->string('max_fishka')->nullable();
            $table->string('name')->nullable();
            $table->string('name2')->nullable();
            $table->string('name3')->nullable();
            $table->string('city_id')->nullable();
            $table->string('obl_id')->nullable();
            $table->string('ray_id')->nullable();
            $table->string('rate')->nullable();
            $table->string('postdone')->nullable();
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
            $table->string('smschecked')->nullable();
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
