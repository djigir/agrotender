<?php

namespace App\Models\Comp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comp\CompItems;


/**
 * Class CompNews
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $comp_id
 * @property integer $visible
 * @property string  $pic_src
 * @property string  $pic_ico
 * @property string  $title
 * @property string  $content
 *
 * @property Carbon $add_date
 */
class CompNews extends Model
{
    protected $table = 'comp_news';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'comp_id',
        'visible',
        'pic_src',
        'pic_ico',
        'title',
        'content',
    ];

    protected $dates = ['add_date'];

    /* Relations */

    public function compItem()
    {
        return $this->belongsTo(CompItems::class, 'id');
    }

}
