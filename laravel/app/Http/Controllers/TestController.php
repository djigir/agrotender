<?php

namespace App\Http\Controllers;

use App\Exports\CompItemsEmailsExport;
use App\Exports\PhoneExport;
use App\Exports\TorgBuyerExport;
use App\Models\ADV\AdvTorgPost;
use App\Models\ADV\AdvTorgTgroups;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class TestController
{

    public function index(Request $request)
    {
        dd(app()->getLocale());
        $torgPost =AdvTorgPost::first();

        dd(  $torgPost->advTorgTopic->subTopic->id);
        $groups = AdvTorgTgroups::query()->select(['id', 'title'])->pluck('title', 'id')->toArray();
        $subgroups = AdvTorgTopic::query()->where('parent_id', '0')->select('id', 'title', 'menu_group_id')->get()->groupBy('menu_group_id')->toArray();
        $groupFilter = [];
        foreach ($groups as $key => $value) {
            $groupFilter[$key + 10000] = $value;
            foreach ($subgroups[$key] as $key2 => $value2)
                $groupFilter[$value2['id']] = '-' . $value2['title'];
        }
        dd($groupFilter);


       dd([
           Regions::query()->pluck('name','id')
       ]);



        /* $rubriks = \App\Models\ADV\AdvTorgTopic::orderBy('menu_group_id')->where('parent_id', 0)->get();
         $rubriks_gr = \App\Models\ADV\AdvTorgTgroups::get();
         $rubrik_select = [];

         foreach ($rubriks_gr as $rubrik_gr) {
             foreach ($rubriks->where('menu_group_id', '=', $rubrik_gr->id) as $rubrik) {
                 $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
             }
         }

         dd($rubrik_select);*/


        /* $model =  AdvTorgPost::query()->find(235935	);*/

        /*      dd(AdvTorgTgroups::query()->with('AdvTorgTopic')->get()->pluck('title','id')->toArray());*/

    }

}
