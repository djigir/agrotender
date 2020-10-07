<?php

namespace App\Services;

use App\Models\Comp\CompTopic;

class TraderService
{
    /**TODO временно**/
    //$rubrics   = $this->db->query("
//      select t.menu_group_id as group_id, t.title, count(i2t.id) as count, i2t.topic_id
//        from agt_comp_topic as t
//        left join agt_comp_item2topic i2t
//          on i2t.topic_id = t.id
//        ".($region != null ? "left join agt_comp_items i on i.id = i2t.item_id" : "")."
//      ".($region != null ? "where i.obl_id = $region" : "")."
//        group by t.id
//        order by t.menu_group_id, t.sort_num, t.title");
//return $rubrics;
    public function DataForFilter()
    {
//        \DB::enableQueryLog();
        $temp = CompTopic::with('comp_topic_item')
            ->select(
                'id',
                'menu_group_id',
                'title',
                'sort_num',
                \DB::raw('count(*) as count, id')
            )
            ->groupBy('id')
            ->get();
//        dd(\DB::getQueryLog());
        dd($temp->toArray());
    }
}
