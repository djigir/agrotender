<?php

namespace App\Services\User;


use App\Models\Comp\CompItems;
use Illuminate\Http\Request;

class ProfileService
{
    public function createCompany(Request $request)
    {
//        $this->db->insert(
//            'agt_comp_items',
//            ['author_id' => $this->id,
//                'topic_id' => 0, 'type_id' => 0,
//                'obl_id' => $region, 'ray_id' => 0,
//                'title' => $title, 'title_full' => '',
//                'city' => $city, 'phone' => '',
//                'phone2' => '', 'phone3' => '',
//                'email' => '', 'www' => '',
//                'zipcode' => $zipcode,
//                'addr' => $addr,
//                'add_date' => 'now()',
//                'content' => $content,
//                'short' => $compshort,
//                'contacts' => '',
//                'logo_file' => $filename]);
//        $compId = $this->db->getLastId();
//        $company = CompItems::create($request->only([
//            ''
//        ]));

        dump($request->all());
    }
}
