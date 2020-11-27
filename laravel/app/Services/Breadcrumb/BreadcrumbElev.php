<?php

namespace App\Services\Breadcrumb;

use App\Models\Regions\Regions;



class BreadcrumbElev
{
    public function setBreadcrumbsElevators($region)
    {
        $breadcrumbs_elev[0] = ['name' => 'Элеваторы', 'url' => ''];
        $arrow = '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>';

        if($region)
        {
            $data = Regions::find($region);
            $breadcrumbs_elev[0] = ['name' => 'Элеваторы'.$arrow, 'url' => route('elev.elevators')];
            $breadcrumbs_elev[1] = ['name' => "Элеваторы в {$data->parental} области", 'url' => ''];
        }

        return $breadcrumbs_elev;
    }


    public function setBreadcrumbsElevator($elev)
    {
        $arrow = '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>';
        $region = Regions::find($elev->obl_id);

        $breadcrumbs_one_elev[0] = ['name' => "{$elev->lang_elevator[0]->name}", 'url' => ''];

        if($region){
            $breadcrumbs_one_elev[0] = ['name' => "{$region->parental} области".$arrow, 'url' => route('elev.region', $region->translit)];
            $breadcrumbs_one_elev[1] = ['name' => "{$elev->lang_elevator[0]->name}", 'url' => ''];
        }

        return $breadcrumbs_one_elev;
    }
}
