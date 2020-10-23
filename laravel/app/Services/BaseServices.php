<?php


namespace App\Services;


use App\Models\Regions\Regions;

class BaseServices
{
    public function getRegions()
    {
        $regions = Regions::get()->toArray();
        array_push($regions, ['name' => 'Вся Украина', 'translit' => 'ukraine']);

        return $regions;
    }

    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = $v;
        }

        $array = array_values($temp_array);

        return $array;

    }

    public function keywords()
    {

    }

    public function description()
    {

    }

    public function breadcrumbs($data = [])
    {

        $breadcrumbs_comp[0] = ['name' => 'Комании в Украине', 'url' => null];
        $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров в Украине', 'url' => null];

        if (isset($data['region'])) {
            $breadcrumbs_comp[0] = ['name' => "Комании в {$data['region']} области", 'url' => null];
            $breadcrumbs_trad[1] = ['name' => "Цена Аграрной продукции в {$data['region']}", 'url' => null];
        }

        if (isset($data['culture'])) {
            $breadcrumbs_comp[0] = ['name' => "Комании в {$data['region']} области", 'url' => null];
            $breadcrumbs_trad[1] = ['name' => "Закупочная цена {} на сегодня в Украине", 'url' => null];
        }

        if (isset($data['region']) && isset($data['rubric'])) {
            $breadcrumbs_comp[0] = ['name' => "Комании в" . isset($data['region']) ? $data['region'] . 'области' : ''  . '<i class="fas fa-chevron-right extra-small"></i>', 'url' => $data['url']];
            $breadcrumbs_comp[1] = ['name' => "Каталог - {$data['rubric']} хозяйства {$data['region2']}", 'url' => null];
            $breadcrumbs_trad[1] = ['name' => "Цена Аграрной продукции в {$data['region']} области", 'url' => null];
        }
        //dd($breadcrumbs_comp, $breadcrumbs_trad);


        return ['company' => $breadcrumbs_comp, 'trader' => $breadcrumbs_trad];
//        return $breadcrumbs = [0 => ['name' => 'Компании в Украине', 'url' => null]];
    }
}
