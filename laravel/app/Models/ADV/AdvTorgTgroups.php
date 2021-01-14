<?php

namespace App\Models\ADV;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property integer $sect0lev_id
 * @property string $title
 * @property string $url
 * @property integer $sort_num

 * @property Carbon $add_date
 * @property Carbon $mod_date
 */
class AdvTorgTgroups extends Model
{
    protected $table = 'adv_torg_tgroups';

    protected $fillable = [
        'id', 'sect0lev_id',
        'add_date', 'mod_date',
        'title', 'url', 'sort_num'
    ];

    public $timestamps = false;

    public function AdvTorgTopic()
    {
        return $this->hasMany(AdvTorgTopic::class, 'menu_group_id', 'id')->where('parent_id',0);
    }
}
