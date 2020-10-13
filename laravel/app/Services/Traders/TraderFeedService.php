<?php

namespace App\Services;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;


class TraderFeedService
{

    const TYPE_SELL = 1;
    const TYPE_FORWARD = 0;
    const TYPES_TEXT = [
        self::TYPE_FORWARD => '_forward',
        self::TYPE_SELL => '_sell'
    ];

    /**
     * @param int $type
     * @return mixed
     */
    public function getFeed($type = self::TYPE_FORWARD)
    {

        $type_text = self::TYPES_TEXT[$type];
        $feed = $this->db->query("
      select ci.title as company, ci.id as company_id, group_concat(distinct concat(tpl.name, ':', ifnull(f.change_price, 3)) order by f.change_price separator ', ') as rubrics, group_concat(distinct ifnull(f.change_price, 3) separator ', ') as change_price, date_format(f.change_date, '%H:%i') as change_time
        from traders_feed f
        inner join agt_traders_products_lang tpl
          on tpl.id = f.rubric
        inner join agt_traders_places tp
          on tp.id = f.place
        inner join agt_comp_items ci
          on ci.author_id = f.user
      where tp.acttype = $type && date(f.change_date) = curdate() && ci.trader_price{$sell}_avail = 1 && ci.trader_price{$sell}_visible = 1 && tp.type_id != 1 && ci.visible = 1
      group by f.user
      order by f.change_date desc");

        foreach ($feed as $key => $value) {
            $feed[$key]['onchange'] = 'Подтвердил цены';
            $feed[$key]['onchange_class'] = 'approve';
            foreach (explode(', ', $value['rubrics']) as $key2 => $value2) {
                $explode = explode(':', $value2);
                if ($explode[1] == '2') {
                    $explode[1] = 4;
                }
                if ($explode[1] != '4') {
                    $feed[$key]['onchange'] = 'Изменил цены';
                    $feed[$key]['onchange_class'] = 'change';
                }
                if (!isset($feed[$key]['r'][$explode[0]]['change'])) {
                    $feed[$key]['r'][$explode[0]]['change'] = [];
                }
                // array_push($feed[$key]['r'][$explode[0]]['change'], $explode[1]);
                $feed[$key]['r'][$explode[0]]['change'][] = $explode[1];
            }
        }
        return $feed;

    }
}
