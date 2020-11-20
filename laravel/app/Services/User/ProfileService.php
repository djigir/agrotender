<?php

namespace App\Services\User;


use App\Http\Requests\LoginPasswordRequest;
use App\Http\Requests\ProfileCompanyRequest;
use App\Http\Requests\ProfileCompanyNewsRequest;
use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompNews;
use App\Models\Comp\CompTopicItem;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use function React\Promise\all;


class ProfileService
{
    const PART_FILE_LOGO_COMPANY = '/pics/c/';
    const PART_FILE_LOGO_NEWS = '/pics/n/';


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

    public function putFileInDirectory($file, $path, $type)
    {
        /** @var User $user */
        $user = auth()->user();

        $fileName = '';

        if($file && $file->getError() == 0)
        {
            $fileName = $file->getClientOriginalName();
            $file->move('/var/www/agrotender'.$path, $fileName);
            $fileName = $path.$fileName;
        }

        if($file == null && $user->company && $type != 'news')
        {
            $fileName = $user->company->logo_file;
        }

        return $fileName;
    }

    public function createOrUpdateCompany(ProfileCompanyRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $author_id = $user->user_id;

        $fileName = $this->putFileInDirectory($request->file('logo'), self::PART_FILE_LOGO_COMPANY, 'company');

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

    public function createOrUpdateNewsCompany(ProfileCompanyNewsRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $fileName = $this->putFileInDirectory($request->file('logo'), self::PART_FILE_LOGO_NEWS, 'news');

        CompNews::create($request->only(['title', 'content']) +
            [
                'comp_id' => $user->company->id,
                'pic_src' => $fileName,
                'visible' => 1,
                'add_date' => Carbon::now()->toDateTimeString()
            ]
        );

    }

    public function createOrUpdateVacancyCompany(ProfileCompanyNewsRequest $request)
    {

    }

    public function getUserCompanyReviews($type)
    {
        /** @var User $user */
        $user = auth()->user();

        // reviews for user company
        if ($type) {
            $company_reviews = CompComment::with('comp_comment_lang')->where('item_id', $user->company->id)->get();
            $reviews = collect();

            foreach ($company_reviews as $key => $company_comment) {
                $reviews->add(CompItems::select('id', 'title', 'logo_file')->where('id', $company_reviews[$key]->item_id)->get()->first());
                $company_reviews[$key]->comp_title = $reviews[$key]->title;
                $company_reviews[$key]->comp_id = $reviews[$key]->id;
                $company_reviews[$key]->comp_logo = $reviews[$key]->logo_file;
            }
            return $company_reviews;

        }
        // user reviews
        $company_comments = CompComment::with('comp_comment_lang')->where('author_id', $user->user_id)->get();
        $company_names = collect();
        foreach ($company_comments as $key => $company_comment) {
            $company_names->add(CompItems::select('id', 'title', 'logo_file')->where('id', $company_comments[$key]->item_id)->get()->first());
            $company_comments[$key]->comp_title = $company_names[$key]->title;
            $company_comments[$key]->comp_id = $company_names[$key]->id;
            $company_comments[$key]->comp_logo = $company_names[$key]->logo_file;
        }
        return $company_comments;
    }
}
