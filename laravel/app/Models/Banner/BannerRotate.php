<?php

namespace App\Models\Banner;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class BannerRotate
 * @package App\Models\Banner
 * @param integer $id;
 * @param integer $position;
 * @param integer $page_type;
 * @param integer $active;
 * @param integer $size_w;
 * @param integer $size_h;
 * @param integer $cost_grn;
 * @param string $name;
 * @param integer $id;
 * @param integer $user_id;
 * @param integer $place_id;
 * @param integer $city_id;
 * @param integer $archive;
 * @param integer $inrotate;

 * @param integer $position;
 * @param string $ban_file;
 * @param string $ban_link;
 * @param integer $ban_w;
 * @param integer $ban_y;
 * @param integer $pay_type;
 * @param string $cont_name;
 * @param string $cont_mail;
 * @param string $promo;
 *
 * @param Carbon $add_date;
 * @param Carbon $dt_start;
 * @param Carbon $dt_end;
 * @param Carbon $dt_start_req;
 * @param Carbon $dt_end_req;
 */
class BannerRotate extends Model
{
    protected $table = 'banner_rotate';

    protected $fillable = [
        'id', 'user_id', 'place_id', 'city_id', 'archive', 'inrotate',
        'position', 'ban_file', 'ban_link', 'ban_w', 'ban_y',
        'pay_type', 'cont_name', 'cont_mail', 'promo'
    ];

    protected $dates = ['dt_start', 'dt_end', 'dt_start_req', 'dt_end_req', 'add_date'];
}
