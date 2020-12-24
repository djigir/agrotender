<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvWordTopic extends Model
{
    protected $table = 'adv_word2topic';

    public $timestamps = false;

    protected $fillable = [
        'id', 'rtopic_id', 'topic_id', 'rating', 'add_date', 'keyword',
    ];


    public function torgTopic()
    {
        return $this->hasMany(AdvTorgTopic::class, 'id', 'topic_id');
    }
}
