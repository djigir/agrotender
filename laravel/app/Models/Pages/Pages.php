<?php

namespace App\Models\Pages;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Pages
 * @package App\Models\Pages
 * @property integer $id;
 * @property integer $parent_id;
 * @property string $page_name;
 * @property integer $sort_num;
 * @property integer $show_in_menu;
 * @property integer $with_editor;
 * @property integer $page_record_type;
 * @property string $page_ico;
 *
 * @property Carbon $create_date;
 * @property Carbon $modify_date
 */
class Pages extends Model
{
    protected $table = 'pages';

    protected $appends = ['pages_lang'];

    protected $fillable = [
        'id', 'parent_id', 'page_name', 'create_date',
        'modify_date', 'sort_num', 'show_in_menu', 'with_editor',
        'page_record_type', 'page_ico',
    ];


    public function getPagesLangAttribute()
    {
        return PagesLang::where('item_id', $this->id)
            ->select('item_id', 'page_mean', 'page_title', 'page_keywords', 'page_descr',
                'title', 'header', 'content', 'page_title')->get()->toArray()[0];
    }

}
