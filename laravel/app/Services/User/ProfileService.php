<?php

namespace App\Services\User;


use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopicItem;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use function React\Promise\all;


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


    public function createOrUpdateCompany(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if($request->isMethod('post'))
        {
            $author_id = auth()->user()->user_id;
            $file = $request->file('logo');
            $fileName = '';

            if($file && $file->getError() == 0)
            {
                $fileName = $file->getClientOriginalName();
                $file->move('/var/www/agrotender'.self::PART_FILE_NAME, $fileName);
                $fileName = self::PART_FILE_NAME.$fileName;
            }

            if($file == null && $user->company)
            {
                $fileName = $user->company->logo_file;
            }

            $compshort = strlen($request->get('content')) > 210 ? Str::limit($request->get('content'), 200) : $request->get('content');

            $company = CompItems::updateOrCreate(['author_id' => $author_id], $request->except(['_token', 'logo']) + [
                'author_id' => $author_id, 'topic_id' => 0, 'type_id' => 0,
                'ray_id' => 0, 'title_full' => '', 'phone' => '', 'short' => $compshort,
                'phone2' => '', 'phone3' => '', 'www' => '', 'add_date' => Carbon::now()->toDateTimeString(),
                'contacts' => '', 'logo_file' => $fileName
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

    public function getLogin()
    {
        if (Auth::user()){
            $get_login = Auth::user()->login;
            return $get_login;
        }else {
            return  null;
        }
    }

    public function getUserReviews()
    {
        $company_comments = CompComment::with('comp_comment_lang')->where('author_id', \auth()->user()->user_id)->get();
        $company_names = collect();
        foreach ($company_comments as $key => $company_comment) {
            $company_names->add(CompItems::select('id', 'title', 'logo_file')->where('id', $company_comments[$key]->item_id)->get()[0]);
            $company_comments[$key]->comp_title = $company_names[$key]->title;
            $company_comments[$key]->comp_id = $company_names[$key]->id;
            $company_comments[$key]->comp_logo = $company_names[$key]->logo_file;
        }

        return $company_comments;
    }
}
