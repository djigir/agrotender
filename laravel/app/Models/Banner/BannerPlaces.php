<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;


/**
 * Class BannerPlaces
 * @package App\Models\Banner
 * @param integer $id;
 * @param integer $position;
 * @param integer $page_type;
 * @param integer $active;
 * @param integer $size_w;
 * @param integer $size_h;
 * @param integer $cost_grn;
 * @param string $name;
 */
class BannerPlaces extends Model
{
    protected $table = 'banner_places';

    protected $fillable = [
        'id',
        'page_type',
        'position',
        'active',
        'size_w',
        'size_h',
        'cost_grn',
        'name'
    ];

    protected $dates = [];
}
