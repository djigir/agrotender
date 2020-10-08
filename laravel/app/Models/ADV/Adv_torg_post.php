<?php

namespace App\Models\ADV;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Adv_torg_post
 * @package App\Models\ADV
 * @property integer $id
 * @property integer $topic_id
 * @property integer $obl_id
 * @property integer $type_id
 * @property integer $author_id
 * @property integer $real_author_id
 * @property integer $company_id
 * @property integer $publish_utype
 * @property integer $active
 * @property integer $moderated
 * @property integer $archive
 * @property integer $targeting
 * @property integer $colored
 * @property integer $fixdone
 * @property Carbon  $add_date
 * @property string  $author
 * @property string  $city
 * @property string  $phone
 * @property string  $phone2
 * @property string  $phone3
 * @property string  $author2
 * @property string  $author3
 * @property string  $email
 * @property string  $title
 * @property string  $content
 * @property string  $amount
 * @property string  $izm
 * @property string  $cost
 * @property string  $cost_izm
 * @property integer $cost_cur
 * @property integer $cost_dog
 * @property integer $ups
 * @property integer $ups_do_notif
 * @property Carbon  $up_dt
 * @property string  $deact_ups_guid
 * @property string  $dub_guid
 * @property Carbon  $upnotif_dt
 * @property integer $viewnum
 * @property integer $viewnum_uniq
 * @property integer $viewnum_cont
 * @property string  $remote_ip
 */

class Adv_torg_post extends Model
{
    protected $table = 'adv_torg_post';

    protected $fillable = [
        'id',
        'topic_id',
        'obl_id',
        'type_id',
        'author_id',
        'real_author_id',
        'company_id',
        'publish_utype',
        'active',
        'moderated',
        'archive',
        'targeting',
        'colored',
        'fixdone',
        'add_date',
        'author',
        'city',
        'phone',
        'phone2',
        'phone3',
        'author2',
        'author3',
        'email',
        'title',
        'content',
        'amount',
        'izm',
        'cost',
        'cost_izm',
        'cost_cur',
        'cost_dog',
        'ups',
        'ups_do_notif',
        'up_dt',
        'deact_ups_guid',
        'dub_guid',
        'upnotif_dt',
        'viewnum',
        'viewnum_uniq',
        'viewnum_cont',
        'remote_ip',
    ];
}
