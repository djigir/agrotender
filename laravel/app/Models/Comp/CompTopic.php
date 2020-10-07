<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

class CompTopic extends Model
{
    protected $table = 'agt_comp_topic';

    protected $fillable = [
        'id',
        'parent_id',
        'sort_num',
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
        return $this->hasMany(CompTopicItem::class, 'topic_id');
    }
}
