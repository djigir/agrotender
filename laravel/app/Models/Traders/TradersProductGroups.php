<?php

namespace App\Models\Traders;


use Illuminate\Database\Eloquent\Model;


/**
 * Class TradersProductGroups
 * @package App\Models\Traders
 * @property integer $id;
 * @property integer $sort_num;
 * @property string $icon_filename;
 * @property string $url;
 * @property integer $acttype;
 */
class TradersProductGroups extends Model
{
    protected $table = 'traders_product_groups';

    protected $fillable = [
        'id',
        'sort_num',
        'icon_filename',
        'url',
        'acttype',
    ];

    protected $appends = ['groups'];

    public function getGroupsAttribute()
    {
        return TradersProductGroupLanguage::select('name', 'id')
            ->where('item_id', '=', $this->id)
            ->with('traders_products')
            ->get()[0];
    }


    public function traders_product_groups_lang()
    {
        return $this->hasOne(TradersProductGroupLanguage::class, 'id');
    }
}
