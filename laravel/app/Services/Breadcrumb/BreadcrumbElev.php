<?php

namespace App\Services\Breadcrumb;

use App\Models\Regions\Regions;



class BreadcrumbElev
{
    public function setBreadcrumbsElevators($region)
    {
        $breadcrumbs_elev[0] = ['name' => 'Элеваторы', 'url' => ''];

        if($region)
        {
            $data = Regions::find($region);
            $breadcrumbs_elev[0] = ['name' => 'Элеваторы', 'url' => route('elev.elevators'), 'arrow' => 'true'];
            $breadcrumbs_elev[1] = ['name' => "Элеваторы в {$data->parental} области", 'url' => ''];
        }

        return $breadcrumbs_elev;
    }


    public function setBreadcrumbsElevator($elev)
    {
        $region = Regions::find($elev->obl_id);

        $breadcrumbs_one_elev[0] = ['name' => "{$elev->lang_elevator[0]->name}", 'url' => ''];

        if($region){
            $breadcrumbs_one_elev[0] = ['name' => "{$region->parental} области", 'url' => route('elev.region', $region->translit), 'arrow' => 'true'];
            $breadcrumbs_one_elev[1] = ['name' => "{$elev->lang_elevator[0]->name}", 'url' => ''];
        }

        return $breadcrumbs_one_elev;
    }
}
