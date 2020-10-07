<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

class CompTopicItem extends Model
{
    protected $table = 'agt_comp_item2topic';

    protected $fillable = [
        'id',
        'topic_id',
        'item_id',
        'sort_num',
    ];

    protected $dates = ['add_date'];


//    public function comp_topic()
//    {
//        return $this->belongsTo(CompTopic::class, 'id');
//    }
}
