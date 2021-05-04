<?php

namespace App\Models\Banner;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Banners
 * @package App\Models\Banner
 * @param integer $id;
 * @param string $linkurl;
 * @param string $filename;
 * @param integer $disptype;
 * @param integer $managetype;
 * @param integer $width;
 * @param integer $height;
 * @param integer $sort_num;
 *
 * @param Carbon $addtime;
 */
class Banners extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'id',
        'linkurl',
        'filename',
        'disptype',
        'managetype',
        'width',
        'height',
        'sort_num',
    ];

    protected $dates = ['addtime'];
}
