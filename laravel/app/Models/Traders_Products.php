<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param string $icon_filename;
 * @param string $url;
 * @param string $group_id;
 * @param string $acttype;
 */

class Traders_Products extends Model
{
    protected $table = 'traders_products';

    protected $fillable = [
        'id',
        'icon_filename',
        'url',
        'group_id',
        'acttype',
    ];
}
