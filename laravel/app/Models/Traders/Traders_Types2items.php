<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $type_id;
 * @param \DateTime $add_date;
 */

class Traders_Types2items extends Model
{
    protected $table = 'traders_types2items';

    protected $fillable = [
        'id',
        'item_id',
        'type_id',
        'add_date',
    ];
}
