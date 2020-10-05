<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $sort_num;
 * @param string $icon_filename;
 * @param string $url;
 * @param string $name;
 */

class Traders_Types extends Model
{
    protected $table = 'traders_types';

    protected $fillable = [
        'id',
        'sort_num',
        'icon_filename',
        'url',
        'name',
    ];
}
