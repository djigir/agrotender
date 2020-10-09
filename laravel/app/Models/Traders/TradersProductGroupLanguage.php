<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;


/**
 * Class TradersProductGroupsLang
 * @package App\Models\Traders
 * @property integer $id;
 * @property integer $item_id;
 * @property integer $lang_id;
 * @property string $name;
 * @property string $descr;
 */
class TradersProductGroupLanguage extends Model
{
    protected $table = 'traders_product_groups_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'name',
        'descr',
    ];

    public function traders_product_group()
    {
        return $this->belongsTo(TradersProductGroups::class, 'item_id');
    }

    public function traders_products()
    {
        return $this->hasMany(TradersProducts::class, 'group_id');
    }
}
