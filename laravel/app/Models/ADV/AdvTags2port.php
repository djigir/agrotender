<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Adv_tags_2port
 * @package App\Models\ADV
 * @property integer $id
 * @property integer $item_id
 * @property integer $tag_id
 *
 */

class AdvTags2port extends Model
{
    protected $table = 'adv_tags_2port';

    protected $fillable = [
        'id',
        'item_id',
        'tag_id',
    ];
}
