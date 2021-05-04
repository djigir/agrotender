<?php

namespace App\Models\BlackNews;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class BlackNews
 * @package App\Models\BlackNews
 * @param integer $id;
 * @param integer $author_id;
 * @param integer $first_page;
 * @param integer $ngroup;
 * @param integer $view_num;
 * @param string $url;
 * @param string $filename_src;
 * @param string $filename_ico;
 * @param string $ddchk_guid;
 *
 * @param Carbon $dtime;
 */
class BlackNews extends Model
{
    protected $table = 'blacknews';

    protected $fillable = [
        'id',
        'author_id',
        'first_page',
        'ngroup',
        'view_num',
        'url',
        'filename_src',
        'filename_ico',
        'ddchk_guid'
    ];

    protected $dates = ['dtime'];
}
