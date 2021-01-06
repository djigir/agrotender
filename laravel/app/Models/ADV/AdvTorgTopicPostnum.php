<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvTorgTopicPostnum extends Model
{
    protected $table = 'adv_torg_topic_postnum';

    protected $fillable = [
        'id', 'topic_id', 'obl_id', 'type_id',
        'all_num', 'num1', 'num2', 'num3',
        'add_date', 'modify_date',
    ];

    public $timestamps = false;

    public function AdvTorgTopic()
    {
        return $this->belongsTo(AdvTorgTopic::class, 'id', 'topic_id');
    }
}
