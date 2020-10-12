<?php


namespace App\Services;


use App\Models\Regions\Regions;

class BaseServices
{
    public function getRegions($rubric = null, $sitemap = null)
    {
        $regions = Regions::get();
//        $regions = $this->db->query("
//      select *
//        from regions
//      group by id");
//        if ($sitemap != null) {
//            $total = 0;
//            foreach ($regions as $key => $value) {
//                $totalTraders = $this->getCountByRubric($rubric, 0, $value['id']);
//                $total = ($total + $totalTraders);
//                $regions[$key]['count'] = $totalTraders;
//            }
//            array_unshift($regions, ['id' => 0, 'name' => 'Украина', 'translit' => 'ukraine', 'count' => $total]);
//        }
        return $regions;
    }
}
