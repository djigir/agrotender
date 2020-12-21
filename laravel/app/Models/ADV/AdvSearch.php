<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvSearch extends Model
{
    protected $table = 'adv_search';

    protected $fillable = [
        'id',
        'gtopic_id',
        'topic_id',
        'keyword',
        'rating',
    ];

    protected $dates = ['add_date'];

    public $timestamps = false;

    /* Relations */

    public function advTorgTopic()
    {
        return $this->hasOne(AdvTorgTopic::class, 'id', 'topic_id');
    }
}
