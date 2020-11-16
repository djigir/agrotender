<?php

namespace App\Services\User;


use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopicItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileService
{
    const PART_FILE_NAME = '/pics/c/';


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

        $author_id = auth()->user()->id;
        $file = $request->file('logo');
        //$file->move('var/www/agrotender'.self::PART_FILE_NAME, $file->getFilename());

        $compshort = strlen($request->get('content')) > 210 ? Str::limit($request->get('content'), 200) : $request->get('content');

        $company = CompItems::updateOrCreate($request->except(['_token', 'logo']) + [
            'author_id' => $author_id, 'topic_id' => 0, 'type_id' => 0,
            'ray_id' => 0, 'title_full' => '', 'phone' => '', 'short' => $compshort,
            'phone2' => '', 'phone3' => '', 'www' => '', 'add_date' => Carbon::now()->toDateTimeString(),
            'contacts' => '', 'logo_file' => self::PART_FILE_NAME.$file->getFilename()
        ], $request->toArray());



////        $company_topic = CompTopicItem::updateOrCreate([]);
 //dd($request->post(), $request->file('logo'), $request->isMethod('get'), $request->isMethod('post'));
//        $this->db->insert('agt_comp_item2topic', ['topic_id' => $rubric, 'item_id' => $compId, 'add_date' => 'now()']);
        //$file = $request->file('logo');
//        \DB::beginTransaction();
//        foreach () {}
//        \DB::commit();

        //dd($request->all());
        //$file->move('var/www/agrotender'.self::PART_FILE_NAME, $file->getFilename());
    }
}
