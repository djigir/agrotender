<?php

namespace App\Services\User;


use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopicItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    const PART_FILE_NAME = '/var/www/agrotender/pics/c/';


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
        /** TODO id поменять на user_id */
        $author_id = auth()->user()->id;
        $file = $request->file('logo');
        $fileName = '';

        if($file->getError() == 0)
        {
            $fileName = $file->getFilename();
            $file->move(self::PART_FILE_NAME, $fileName.'.'.$file->getClientOriginalExtension());
        }

        $compshort = strlen($request->get('content')) > 210 ? Str::limit($request->get('content'), 200) : $request->get('content');

        $company = CompItems::updateOrCreate(['author_id' => $author_id], $request->except(['_token', 'logo']) + [
            'author_id' => $author_id, 'topic_id' => 0, 'type_id' => 0,
            'ray_id' => 0, 'title_full' => '', 'phone' => '', 'short' => $compshort,
            'phone2' => '', 'phone3' => '', 'www' => '', 'add_date' => Carbon::now()->toDateTimeString(),
            'contacts' => '', 'logo_file' => self::PART_FILE_NAME.$fileName
        ], $request->toArray());

        CompTopicItem::where('item_id', $company->id)->delete();

        \DB::beginTransaction();
            foreach ($request->get('rubrics') as $index => $rubric) {
                CompTopicItem::create([
                    'topic_id' => (int)$rubric,
                    'item_id' => $company->id,
                    'add_date' => Carbon::now()->toDateTimeString()
                ]);
            }
        \DB::commit();

    }
}
