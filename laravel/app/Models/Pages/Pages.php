<?php

namespace App\Models\Pages;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Pages
 * @package App\Models\Pages
 * @param integer $id;
 * @param integer $parent_id;
 * @param string $page_name;
 * @param integer $sort_num;
 * @param integer $show_in_menu;
 * @param integer $with_editor;
 * @param integer $page_record_type;
 * @param string $page_ico;
 *
 * @property Carbon $create_date;
 * @property Carbon $modify_date
 */
class Pages extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'id', 'parent_id', 'page_name', 'create_date',
        'modify_date', 'sort_num', 'show_in_menu', 'with_editor',
        'page_record_type', 'page_ico',
    ];

}
