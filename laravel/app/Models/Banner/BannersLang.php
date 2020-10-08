<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;


/**
 * Class BannersLang
 * @package App\Models\Banner
 * @param integer $id;
 * @param integer $banner_id;
 * @param string $alttext;
 * @param integer $lang_id;
 */
class BannersLang extends Model
{
    protected $table = 'banners_lang';

    protected $fillable = ['id', 'banner_id', 'alttext', 'lang_id'];

    protected $dates = [];
}
