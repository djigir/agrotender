<?php

namespace App\Services\User;


use App\Http\Requests\LoginPasswordRequest;
use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompItems;
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
            $author_id = $user->user_id;
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

    public function getUserReviews($type)
    {
        /** @var User $user */
        $user = auth()->user();

        $company_comments = CompComment::with('comp_comment_lang')->where('author_id', $user->user_id)->get();
        $company_names = collect();
        foreach ($company_comments as $key => $company_comment) {
            $company_names->add(CompItems::select('id', 'title', 'logo_file')->where('id', $company_comments[$key]->item_id)->get()[0]);
            $company_comments[$key]->comp_title = $company_names[$key]->title;
            $company_comments[$key]->comp_id = $company_names[$key]->id;
            $company_comments[$key]->comp_logo = $company_names[$key]->logo_file;
        }

        return $company_comments;
    }

    public function userHasCompany()
    {
        $user_company = CompItems::where('author_id', \auth()->user()->user_id)->get()->first();
        return $user_company;
    }

//    public function getNewsItem($newId, $company) {
//        return $this->db->select('agt_comp_news', '*', ['id' => $newId, 'comp_id' => $company])[0] ?? null;
//    }
//
//    public function getNews($company) {
//        return $this->db->query("select * from agt_comp_news where comp_id = $company order by id desc");
//    }
//
//    public function addNews($company, $title, $image, $description) {
//        if ($title == null) {
//            $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
//        }
//        if ($description == null) {
//            $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
//        }
//        if ($image != null && $image['error'] == 0) {
//            $tmp      = $image['tmp_name'];
//            $type     = explode('/', $image['type'])[0];
//            if ($type != 'image') {
//                $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
//            }
//            $filename = $this->model('utils')->getHash(12).'.'.pathinfo($image['name'])['extension'];
//            move_uploaded_file($tmp, PATH['root'].'/pics/n/'.$filename);
//            $filename = 'pics/n/'.$filename;
//        } else {
//            $filename = '';
//        }
//        $this->db->insert('agt_comp_news', ['title' => $title, 'pic_src' => $filename, 'content' => $description, 'add_date' => 'now()', 'visible' => 1, 'comp_id' => $company]);
//        $this->response->json(['code' => 1, 'text' => '']);
//    }
//
//    public function editNews($company, $newsId, $title, $image, $description) {
//        if ($title == null) {
//            $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
//        }
//        if ($description == null) {
//            $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
//        }
//        $newsItem = $this->getNewsItem($newsId, $company);
//        if ($newsItem == null) {
//            $this->response->json(['code' => 0, 'text' => 'Новость ещё не создана.']);
//        }
//        if ($image != null && $image['error'] == 0) {
//            $tmp      = $image['tmp_name'];
//            $type     = explode('/', $image['type'])[0];
//            if ($type != 'image') {
//                $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
//            }
//            $filename = $this->model('utils')->getHash(12).'.'.pathinfo($image['name'])['extension'];
//            move_uploaded_file($tmp, PATH['root'].'/pics/n/'.$filename);
//            if ($newsItem['pic_src'] != '') {
//                unlink(PATH['root'].'/'.$newsItem['pic_src']);
//            }
//            $filename = 'pics/n/'.$filename;
//        } else {
//            $filename = $newsItem['pic_src'];
//        }
//        $this->db->update('agt_comp_news', ['title' => $title, 'pic_src' => $filename, 'content' => $description], ['id' => $newsId, 'comp_id' => $company]);
//        $this->response->json(['code' => 1, 'text' => '']);
//    }
//
//    public function removeNews($company, $newsId) {
//        $newsItem = $this->getNewsItem($newsId, $company);
//        if ($newsItem == null) {
//            $this->response->json(['code' => 0, 'text' => 'Новость ещё не создана.']);
//        }
//        unlink(PATH['root'].'/'.$newsItem['pic_src']);
//        $this->db->delete('agt_comp_news', ['id' => $newsId]);
//        $this->response->json(['code' => 1, 'text' => '']);
//    }
}
