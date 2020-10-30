<?php

namespace App\Models\Comp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
* @property  integer $id
* @property  integer $parent_id
* @property  integer $sort_num
* @property  Carbon $add_date
* @property  integer $menu_group_id
* @property  string $title
* @property  string $descr
* @property  string $page_h1
* @property  string $page_title
* @property  string $page_keywords
* @property  string $page_descr
*/
class CompTopic extends Model
{
    protected $table = 'comp_topic';

    protected $fillable = [
        'id',
        'parent_id',
        'sort_num',
        'add_date',
        'menu_group_id',
        'title',
        'descr',
        'page_h1',
        'page_title',
        'page_keywords',
        'page_descr',
    ];

    protected $dates = ['add_date'];

    public function comp_topic_item()
    {
        return $this->hasMany(CompTopicItem::class, 'topic_id', 'id');
    }

    public function comp_groups()
    {
        return $this->belongsTo(CompTgroups::class, 'id');
    }
}
