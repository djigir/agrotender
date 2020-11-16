<?php

namespace App\Services\User;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopicItem;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class ProfileService
{
    const PART_FILE_NAME = '/pics/';

    public function createCompanyValidator(array $data)
    {
        /** @var Validator $validator */
        $validator = Validator::make($data, [
            'title' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required',
            'obl_id' => 'required',
            'rubrics' => 'min:1|max:5',
        ])->validate();

        return $validator;
    }


    public function createCompany(Request $request)
    {
        /** var User $user */
        if($request->isMethod('post'))
        {
            $author_id = auth()->user()->user_id;
            $file = $request->file('logo');
            $fileName = '';

            if($file && $file->getError() == 0)
            {
                $fileName = $file->getClientOriginalName();
                $file->move('/var/www/agrotender'.self::PART_FILE_NAME, $fileName);
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
}
