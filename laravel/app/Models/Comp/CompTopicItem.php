<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;


/**
 * @method static updateOrCreate(array $array, array $data)
 * @method static create(array $data)
*/
class CompTopicItem extends Model
{
    protected $table = 'comp_item2topic';

    protected $fillable = [
        'id',
        'topic_id',
        'item_id',
        'sort_num',
        'add_date'
    ];

    public $timestamps = false;

    public function comp_items()
    {
        return $this->belongsTo(CompItems::class, 'id', 'item_id');
    }

    public function comp_topic()
    {
        return $this->hasMany(CompTopic::class, 'id', 'topic_id');
    }


    public function compTopic()
    {
        return $this->hasMany(CompTopic::class, 'id', 'topic_id');
    }

    public function compTopicRevers()
    {
        return $this->belongsTo(CompTopic::class, 'id');
    }
}
