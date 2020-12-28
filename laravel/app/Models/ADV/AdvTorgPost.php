<?php

namespace App\Models\ADV;

use App\Models\Comp\CompItems;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
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
 * @property string  $deact_ups_guid
 * @property string  $dub_guid
 * @property integer $viewnum
 * @property integer $viewnum_uniq
 * @property integer $viewnum_cont
 * @property string  $remote_ip
 *
 * @property Carbon  $upnotif_dt
 * @property Carbon  $up_dt
 * @property Carbon  $add_date
 */

class AdvTorgPost extends Model
{
    protected $table = 'adv_torg_post';

    protected $fillable = [
        'id', 'topic_id', 'obl_id', 'type_id', 'author_id', 'real_author_id', 'company_id', 'publish_utype',
        'active', 'moderated', 'archive', 'targeting', 'colored', 'fixdone', 'author', 'city', 'phone', 'phone2',
        'phone3', 'author2', 'author3', 'email', 'title', 'content', 'amount', 'izm', 'cost',
        'cost_izm', 'cost_cur', 'cost_dog', 'ups', 'ups_do_notif', 'deact_ups_guid', 'dub_guid', 'viewnum', 'viewnum_uniq', 'viewnum_cont', 'remote_ip',
    ];

    protected $dates = ['up_dt', 'upnotif_dt', 'add_date'];


    public function advertsType()
    {
        $model = $this;

        switch ($model->type_id) {
            case 1:
                $model->rubric_name = 'Куплю';
                break;
            case 2:
                $model->rubric_name = 'Продам';
                break;
            case 3:
                $model->rubric_name = 'Услуги';
                break;
        }
        return $model;
    }

    public function regions()
    {
        return $this->hasOne(Regions::class, 'id', 'obl_id');
    }

    public function advTorgTopic()
    {
        return $this->hasOne(AdvTorgTopic::class, 'id', 'topic_id');
    }

    public function torgBuyer()
    {
        return $this->hasOne(TorgBuyer::class, 'id', 'author_id');
    }

    public function compItems()
    {
        return $this->hasOne(CompItems::class, 'id', 'author_id');
    }

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTypeAdverts($query, $type)
    {
        $type_id = $type['type_id'];
        $comp_id = $type['comp_id'];

        return $query->where('type_id', $type_id)->where('company_id', $comp_id);
    }

    public function scopeTorgBuyerAdverts($query, $type)
    {
        $author_id = $type['author_id'];

        return $query->where('author_id', $author_id);
    }

}
