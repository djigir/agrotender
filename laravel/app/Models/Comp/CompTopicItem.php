<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

class CompTopicItem extends Model
{
    protected $table = 'comp_item2topic';

    protected $fillable = [
        'id',
        'topic_id',
        'item_id',
        'sort_num',
    ];

    protected $dates = ['add_date'];

    public function comp_items()
    {
        return $this->belongsTo(CompItems::class, 'id', 'item_id');
    }

    public function comp_topic()
    {
        return $this->belongsTo(CompTopic::class, 'id');
    }


}
