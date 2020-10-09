<?php


namespace App\Services;


use App\Models\Comp\CompItems;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use Symfony\Component\HttpFoundation\Request;

class CompanyService
{
    const PER_PAGE = 10;



    public function getRegion($region) {

//        $region = $this->db->query("
//      select * from regions where ".(is_int($region) ? "id = '$region' or " : "")."name = '$region' or translit = '$region'
//    ")[0] ?? [
//                "name"     => "Украина",
//                "r"        => "Украине",
//                "translit" => "ukraine",
//                "id"       => null
//            ];
//        return $region;
    }

    public function getRubrics($region = null) {



//        $rubrics   = $this->db->query("
//      select t.menu_group_id as group_id, t.title, count(i2t.id) as count, i2t.topic_id
//        from agt_comp_topic as t
//        left join agt_comp_item2topic i2t
//          on i2t.topic_id = t.id
//        ".($region != null ? "left join agt_comp_items i on i.id = i2t.item_id" : "")."
//      ".($region != null ? "where i.obl_id = $region" : "")."
//        group by t.id
//        order by t.menu_group_id, t.sort_num, t.title");
//        return $rubrics;
    }

    public function getRubricsChunk($region = null) {
//        $rubrics = $this->getRubrics($region);
//        $result  = [];
//        foreach ($rubrics as $r) {
//            $result[$r['group_id']][] = $r;
//        }
//        foreach ($result as $key => $value) {
//            $result[$key] = array_chunk($value, 7);
//        }
//        return $result;
    }

    public function getRubricsGroup() {
//        \DB::enableQueryLog();
        //        dd(\DB::getQueryLog());

        return CompTgroups::with(['comp_topic' => function ($query) {
            $query->where('parent_id', '=', 0);
        }])->get();

//            $this->db->query("
//      select distinct g.id, g.title, g.sort_num
//        from agt_comp_topic t
//        left join agt_comp_tgroups g
//          on t.menu_group_id = g.id
//      where t.parent_id = 0
//        order by g.sort_num, g.title");


    }

    public function getRubric($id) {
//        $rubric = $this->db->query("select * from agt_comp_topic where id = $id")[0] ?? null;
//        return $rubric;
    }

    public function getCompanies()
    {
//        $rubric = ($rubric != null) ? "inner join agt_comp_item2topic i2t on i2t.item_id = i.id && i2t.topic_id = $rubric" : "";
//        $region = ($region != null) ? "&& i.obl_id = $region" : "";
//        $query  = ($query != null) ?  "&& (i.title like '%$query%' or i.content like '%$query%')" : "";
        $companies = CompItems::
        select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
            'short', 'add_date', 'visible', 'obl_id', 'title', 'trader_price_avail',
            'trader_price_visible', 'phone', 'phone2', 'phone3'
        )->paginate(self::PER_PAGE);
        //dd($companies->toArray()['data']);
        return $companies;
    }
}
