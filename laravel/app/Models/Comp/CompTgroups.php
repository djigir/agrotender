<?php

namespace App\Models\Comp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class CompTgroups
 * @package App\Models\Regions
 * @property integer $id
 * @property integer $sect0lev_id
 * @property integer $sort_num
 * @property string  $url
 * @property string  $title
 *
 * @property Carbon $add_date
 * @property Carbon $mod_date
 */
class CompTgroups extends Model
{
    protected $table = 'comp_tgroups';

    protected $fillable = [
        'id',
        'sect0lev_id',
        'title',
        'url',
        'sort_num',
    ];

    protected $dates = ['add_date', 'mod_date'];


    public $timestamps = false;

    public function comp_topic()
    {
         return $this->hasMany(CompTopic::class, 'menu_group_id');
    }

    public function compTopic()
    {
        return $this->hasMany(CompTopic::class, 'menu_group_id');
    }
}
