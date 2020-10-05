<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $sort_num;
 * @param string $icon_filename;
 * @param string $url;
 * @param integer $acttype;
 */

class TradersProductGroupsLang extends Model
{
    protected $table = 'traders_product_groups_lang';

    protected $fillable = [
        'id',
        'sort_num',
        'icon_filename',
        'url',
        'acttype',
    ];
}
