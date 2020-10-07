<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $lang_id;
 * @param string $name;
 * @param string $descr;
 * @param string $descr2;
 * @param string $tbl_dat;
 * @param string $tbl_valid_to;
 * @param string $tbl_dat2;
 * @param string $tbl_valid_to2;
 * @param string $seo_title;
 * @param string $seo_keyw;
 * @param string $seo_descr;
 */


class Traders_Lang extends Model
{
    protected $table = 'traders_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'name',
        'descr',
        'descr2',
        'tbl_dat',
        'tbl_valid_to',
        'tbl_dat2',
        'tbl_valid_to2',
        'seo_title',
        'seo_keyw',
        'seo-descr'
    ];
}
