<?php

namespace App\Models\Comp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompItems
 * @package App\Models\Comp
 * @property integer $id;
 * @property integer $comp_id;
 * @property integer $type_id;
 * @property integer $visible;
 * @property integer $sort_num;
 * @property string $region;
 * @property string $dolg;
 * @property string $fio;
 * @property string $phone;
 * @property string $fax;
 * @property string $email;
 * @property string $pic_src;
 * @property string $pic_ico;
 * @property integer $buyer_id;
 *
 * @property Carbon $add_date;
 **/

class CompItemsContact extends Model
{
    protected $connection = 'mysql';

    protected $table = 'comp_items_contact';

    protected $fillable = [
        'id',
        'comp_id',
        'type_id',
        'visible',
        'sort_num',
        'add_date',
        'region',
        'dolg',
        'fio',
        'phone',
        'fax',
        'email',
        'pic_src',
        'pic_ico',
        'buyer_id',
    ];

    public function compItems()
    {
        return $this->belongsTo(CompItems::class, 'id');
    }

    public function compItems2()
    {
        return $this->belongsTo(CompItems::class, 'id');
    }
}
