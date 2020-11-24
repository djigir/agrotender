<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProfileCompanyRequest;
use App\Http\Requests\ProfileCompanyNewsRequest;
use App\Http\Requests\LoginPasswordRequest;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Comp\CompNews;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Comp\CompVacancy;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use App\Services\User\AdvertService;
use App\Services\BaseServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\User\ApplicationService;
use App\Services\User\ProfileService;
use App\Services\User\TariffService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function __construct(
        AdvertService $advertService,
        ApplicationService $applicationService,
        ProfileService $profileService,
        TariffService $tariffService,
        BaseServices $baseServices
    )
    {
        $this->agent = new \Jenssegers\Agent\Agent;
        $this->advertService = $advertService;
        $this->applicationService = $applicationService;
        $this->profileService = $profileService;
        $this->tariffService = $tariffService;
        $this->baseServices = $baseServices;
    }

    //М-д для страницы профиля (авторизация)
    public function profile()
    {
        return view('private_cabinet.profile.profile', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[0],
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

        if (!$loginPasswordRequest->validated()) {
            return redirect()->back()
                ->withInput($loginPasswordRequest->all())
                ->withErrors(['msg' => 'Ошибка изменения логина']);
        }

        TorgBuyer::where('id', $user->user_id)->update($loginPasswordRequest->only(['login']) +
            ['email' => $loginPasswordRequest->get('login')]
        );

        User::where('id', $user->id)->update($loginPasswordRequest->only(['login']) +
            ['email' => $loginPasswordRequest->get('login')]
        );

        return  redirect()->route('user.profile.profile')->with(['success' => 'Email успешно изменен!']);
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
        $type_department = $request->get('dep');
        $contacts = $this->profileService->userCompanyContact($type_department);
        $regions = $this->baseServices->getRegions()->forget(25);

        return view('private_cabinet.profile.contacts', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[1],
            'contacts' => $contacts,
            'regions' => $regions,
            'type' => $type_department,
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
        return view('private_cabinet.profile.notify', [
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
        return view('private_cabinet.profile.reviews', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[3],
            'type' => $type,
            'reviews' => $reviews,
            'user_company' => $user_company,
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

        return view('private_cabinet.profile.company', [
            'regions' => $regions,
            'company' => $company,
            'rubrics' => $rubrics,
            'select_rubric' => $select_rubric,
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

        return view('private_cabinet.profile.news', [
            'type_page' => self::TYPE_PAGE[0],
            '$newsItem' => $newsItem,
            'news' => $news,
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
        CompNews::find($request->get('news_id'))->update($request->only([
            'content', 'title'
        ]));

        return response()->json($request->all(), 200);
    }

    public function printNews(Request $request)
    {
        $newsItem = CompNews::find($request->get('news_id'));

        return response()->json($newsItem, 200);
    }


    public function createVacancy(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $vacancies = CompVacancy::create($request->all() + ['comp_id' => $user->company->id, 'visible' => 1, 'add_date' => Carbon::now()]);
        if ($vacancies){
            return redirect()->back();
        }
    }

    //Если есть созданая компания тогда + новая страница профиля (вакансии)
    public function profileVacancy()
    {
        $user = auth()->user();
        $vacancies = CompVacancy::where('comp_id', $user->company->id)->orderBy('add_date', 'DESC')->get();

        return view('private_cabinet.profile.vacancy', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[6],
            'vacancies' => $vacancies,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы объявления
    public function advert()
    {
        return view('private_cabinet.advert.advert', [
            'type_page' => self::TYPE_PAGE[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/лимитивные тарифы
    public function advertLimit()
    {
        return view('private_cabinet.advert.limits', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/улучшения обьявлений
    public function advertUpgrade()
    {
        return view('private_cabinet.advert.upgrade', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/поплнить балансе
    public function balancePay()
    {
        return view('private_cabinet.tariff.balance_pay', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/история платежей
    public function balanceHistory()
    {
        return view('private_cabinet.tariff.balance_history', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[3],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/счета-акты
    public function balanceDocs()
    {
        return view('private_cabinet.tariff.balance_docs', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[4],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы заявки
    public function application()
    {
        return view('private_cabinet.application.application', [
            'type_page' => self::TYPE_PAGE[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }
}
