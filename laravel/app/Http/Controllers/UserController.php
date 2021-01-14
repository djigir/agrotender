<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProfileCompanyRequest;
use App\Http\Requests\ProfileCompanyNewsRequest;
use App\Http\Requests\LoginPasswordRequest;
use App\Http\Requests\ProfileUserCompanyVacancyRequest;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Comp\CompNews;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Comp\CompVacancy;
use App\Models\Elevators\TorgElevator;
use App\Models\Elevators\TorgElevatorLang;
use App\Models\Rayon\Rayon;
use App\Models\Rayon\RayonLang;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use App\Models\Users\Users;
use App\Notifications\CustomChangeLoginNotification;
use App\Services\ProfileMetaService;
use App\Services\User\AdvertService;
use App\Services\BaseServices;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use App\Services\User\ApplicationService;
use App\Services\User\ProfileService;
use App\Services\User\TariffService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    const TYPE_PAGE = [
        0 => 'profile',
        1 => 'advert',
        2 => 'application',
        3 => 'tariff',
    ];

    const TYPE_PAGE_PROFILE = [
        0 => 'profile',
        1 => 'contacts',
        2 => 'notify',
        3 => 'reviews',
        4 => 'company',
        5 => 'news',
        6 => 'vacancy',
    ];

    const TYPE_PAGE_TARIFF = [
        0 => 'advert_limit',
        1 => 'advert_upgrade',
        2 => 'balance_pay',
        3 => 'balance_history',
        4 => 'balance_docs',
    ];


    protected $agent;
    protected $advertService;
    protected $applicationService;
    protected $profileService;
    protected $tariffService;
    protected $baseServices;
    protected $profileMetaService;

    public function __construct(
        AdvertService $advertService,
        ApplicationService $applicationService,
        ProfileService $profileService,
        TariffService $tariffService,
        BaseServices $baseServices,
        ProfileMetaService $profileMetaService
    )
    {
        $this->agent = new \Jenssegers\Agent\Agent;
        $this->advertService = $advertService;
        $this->applicationService = $applicationService;
        $this->profileService = $profileService;
        $this->tariffService = $tariffService;
        $this->baseServices = $baseServices;
        $this->profileMetaService = $profileMetaService;
    }

    //М-д для страницы профиля (авторизация)
    public function profile()
    {
        /* для авторизации из админки  */
        $user_id = \request()->get('user_id');
        $user_old = TorgBuyer::find($user_id)->toArray();
        $user = User::firstOrCreate(['user_id' => $user_old['id']], $user_old);
        \auth()->login($user);
        /* для авторизации из админки  */


        $meta = $this->profileMetaService->profile();
        return view('private_cabinet.profile.profile', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[0],
            'page_type' => null,
            'type_page_profile' => self::TYPE_PAGE_PROFILE[0],
            'page_type' => self::TYPE_PAGE[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    // изменить пароль
    public function changePass(LoginPasswordRequest $loginPasswordRequest)
    {
        /** @var User $user */
        $user = auth()->user();

        $old_pass = $loginPasswordRequest->get('oldPassword');
        $new_pass = $loginPasswordRequest->get('passwd');

        if (!Hash::check($old_pass, $user->passwd) && $new_pass){
            return redirect()->back()
                ->withInput($loginPasswordRequest->all())
                ->withErrors(['msg' => 'Старый пароль указан неправильно.']);
        }

        TorgBuyer::where('id', $user->user_id)->update(['passwd' => Hash::make($new_pass)]);

        User::where('id', $user->id)->update(['passwd' => Hash::make($new_pass)]);

        return  redirect()->route('user.profile.profile')->with(['success' => 'Пароль изменён']);
    }


    // изменить login
    public function changeLogin(LoginPasswordRequest $loginPasswordRequest)
    {
        /** @var User $user */
        $user = auth()->user();

        $token = Str::random(32);
        $user->sendPasswordResetNotification($token);

        return view('private_cabinet.info-page.success', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function successEmailChanged()
    {
        return view('private_cabinet.info-page.email_changed', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function toggleVisible(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        CompItems::find($user->company->id)->update($request->only(['visible']));

        return redirect()->route('user.profile.company');
    }


    //М-д для страницы профиля (контакты)
    public function profileContacts(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $type_department = $request->get('dep');

        if ($user->company == null && $type_department == 1 ||
            $user->company == null && $type_department == 2 ||
            $user->company == null && $type_department == 3) {
            return redirect()->route('user.profile.company')->withErrors(['msg' => 'Для начала создайте компанию']);
        }

        $contacts = $this->profileService->userCompanyContact($type_department);
        $regions = $this->baseServices->getRegions()->forget(25);

        $meta = $this->profileMetaService->profileContacts();
        return view('private_cabinet.profile.contacts', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[1],
            'contacts' => $contacts,
            'regions' => $regions,
            'type' => $type_department,
            'meta' => $meta,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function changeContacts(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $dep_type = $request->get('type');

        $contacts_data = $request->only(['name', 'name2', 'phone2', 'name3', 'phone3', 'email', 'obl_id', 'city']);
        if ($request->get('type_id') == 999){
            $contacts_data = $request->only(['telegram', 'viber']);
        }
        // Главный офис
        $contacts_torg = TorgBuyer::where('id', $user->user_id)->update($contacts_data);
        $contacts_user = User::where('id', $user->id)->update($contacts_data);

        // Telegram/Viber

        return redirect()->back()->with(['success' => 'Данные сохранены.']);
    }

    public function createContacts(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $dep_type = $request->get('type');

        // Отдел закупок
        $department_contacts = CompItemsContact::create($request->all() + [
                'comp_id' => $user->company->id,
                'buyer_id' => $user->user_id,
                'add_date' => Carbon::now()]);

        return redirect()->back()->with(['success' => 'Данные сохранены.']);
    }

    //М-д для страницы профиля (уведомления)
    public function profileNotify()
    {
        $meta = $this->profileMetaService->profileNotify();
        return view('private_cabinet.profile.notify', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы профиля (отзывы)
    public function profileReviews(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $type = $request->get('type');

        $reviews = $this->profileService->getUserCompanyReviews($type);
        $user_company = $user->company();

        $meta = $this->profileMetaService->profileReviews();

        return view('private_cabinet.profile.reviews', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[3],
            'type' => $type,
            'reviews' => $reviews,
            'user_company' => $user_company,
            'meta' => $meta,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы профиля (компании) ProfileCompanyRequest
    public function profileCompany()
    {
        /** @var User $user */
        $user = auth()->user();

        $company = [];

        if ($user) {
            $company = $user->company;
        }

        $regions = $this->baseServices->getRegions()->forget(25);
        $rubrics = CompTgroups::with(['comp_topic' => function ($query) {
            $query->select('menu_group_id', 'title', 'id')->where('parent_id', 0);
        }])->orderBy('sort_num')->orderBy('title')->get();

        $select_rubric = !empty($company) ? CompTopicItem::where('item_id', $company->id)->pluck('topic_id', 'topic_id') : [];

        $meta = $this->profileMetaService->profileCompany();

        return view('private_cabinet.profile.company', [
            'regions' => $regions,
            'company' => $company,
            'rubrics' => $rubrics,
            'select_rubric' => $select_rubric,
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[4],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function createCompanyProfile(ProfileCompanyRequest $request)
    {
        if (!$request->validated()){
            return redirect()->back()->withInput($request->input())->withErrors($request->validated());
        }

        $this->profileService->createOrUpdateCompany($request);

        return redirect()->route('user.profile.company');
    }


    //Если есть созданая компания тогда + новая страница профиля (новости)
    public function profileNews(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $newsItem = [];
        $news = CompNews::where('comp_id', $user->company->id)->orderBy('id', 'desc')->get();

        if($request->get('news_id')){
            $newsItem = CompNews::find($request->get('news_id'));
        }

        $meta = $this->profileMetaService->profileNews();

        return view('private_cabinet.profile.news', [
            'type_page' => self::TYPE_PAGE[0],
            '$newsItem' => $newsItem,
            'news' => $news,
            'meta' => $meta,
            'type_page_profile' => self::TYPE_PAGE_PROFILE[5],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function actionNews(ProfileCompanyNewsRequest $request)
    {
        if ($request->validated()){
            $this->profileService->createOrUpdateNewsCompany($request);
            return redirect()->route('user.profile.news');
        }

        return false;
    }


    public function editNews(ProfileCompanyNewsRequest $request)
    {
        $this->profileService->UpdateNewsCompany($request);
        return response()->json($request->all(), 200);
    }

    public function printNews(Request $request)
    {
        $newsItem = CompNews::find($request->get('news_id'));

        return response()->json($newsItem, 200);
    }

    public function deleteNews(Request $request)
    {
        CompNews::find($request->get('news_id'))->delete();

        return response()->json($request->all(), 200);
    }

    /* no ajax */
    public function createVacancy(ProfileCompanyNewsRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if($request->validated()){
            CompVacancy::create($request->only(['title', 'content']) +
                ['comp_id' => $user->company->id, 'visible' => 1, 'add_date' => Carbon::now()]);
            return redirect()->back();
        }

        return false;
    }

    /* show for edit vacancy ajax */
    public function printVacancy(Request $request)
    {
        $contactsItem = CompVacancy::find($request->get('vacancyId'));
        return response()->json($contactsItem, 200);
    }

    public function editVacancy(ProfileCompanyNewsRequest $request)
    {
        CompVacancy::find($request->get('vacancyId'))->update($request->only([
            'content', 'title'
        ]));
        return response()->json($request->all(), 200);
    }

    public function deleteVacancy(Request $request)
    {
        CompVacancy::find($request->get('vacancyId'))->delete();
        return response()->json($request->all(), 200);
    }


    //Если есть созданая компания тогда + новая страница профиля (вакансии)
    public function profileVacancy()
    {
        $user = auth()->user();
        $vacancies = CompVacancy::where('comp_id', $user->company->id)->orderBy('add_date', 'DESC')->get();

        $meta = $this->profileMetaService->profileVacancy();

        return view('private_cabinet.profile.vacancy', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[6],
            'vacancies' => $vacancies,
            'meta' => $meta,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы объявления
    public function advert()
    {
        $meta = $this->profileMetaService->advert();

        return view('private_cabinet.advert.advert', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/лимитивные тарифы
    public function advertLimit()
    {

        $meta = $this->profileMetaService->advertLimit();

        return view('private_cabinet.advert.limits', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/улучшения обьявлений
    public function advertUpgrade()
    {
        $meta = $this->profileMetaService->advertUpgrade();

        return view('private_cabinet.advert.upgrade', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/поплнить балансе
    public function balancePay()
    {
        $meta = $this->profileMetaService->balancePay();

        return view('private_cabinet.tariff.balance_pay', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/история платежей
    public function balanceHistory()
    {
        $meta = $this->profileMetaService->balanceHistory();

        return view('private_cabinet.tariff.balance_history', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[3],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/счета-акты
    public function balanceDocs()
    {
        $meta = $this->profileMetaService->balanceDocs();

        return view('private_cabinet.tariff.balance_docs', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[4],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы заявки
    public function application()
    {
        $meta = $this->profileMetaService->application();

        return view('private_cabinet.application.application', [
            'meta' => $meta,
            'type_page' => self::TYPE_PAGE[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }
}
