<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProfileCompanyRequest;
use App\Http\Requests\LoginPasswordRequest;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use App\Services\User\AdvertService;
use App\Services\BaseServices;
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
        $old_pass = $loginPasswordRequest->get('oldPassword');
        $new_pass = $loginPasswordRequest->get('passwd');

        if (!Hash::check($old_pass, auth()->user()->passwd) && $new_pass){
            return redirect()->back()
                ->withInput($loginPasswordRequest->all())
                ->withErrors(['msg' => 'Старый пароль указан неправильно.']);
        }

        TorgBuyer::where('id', auth()->user()->user_id)->update(['passwd' => Hash::make($new_pass)]);

        User::where('id', auth()->user()->id)->update(['passwd' => Hash::make($new_pass)]);

        return  redirect()->route('user.profile.profile')->with(['success' => 'Пароль изменён']);
    }


    // изменить login
    public function changeLogin(LoginPasswordRequest $loginPasswordRequest)
    {
        if (!$loginPasswordRequest->validated()) {
            return redirect()->back()
                ->withInput($loginPasswordRequest->all())
                ->withErrors(['msg' => 'Ошибка изменения логина']);
        }

        TorgBuyer::where('id', auth()->user()->user_id)->update($loginPasswordRequest->only(['login']) +
            ['email' => $loginPasswordRequest->get('login')]
        );

        User::where('id', \auth()->user()->id)->update($loginPasswordRequest->only(['login']) +
            ['email' => $loginPasswordRequest->get('login')]
        );

        return  redirect()->route('user.profile.profile')->with(['success' => 'Email успешно изменен!']);
    }

    public function toggleVisible(Request $request)
    {
        $user = auth()->user();

        CompItems::find($user->company->id)->update($request->only(['visible']));

        return redirect()->route('user.profile.company');
    }


    //М-д для страницы профиля (контакты)
    public function profileContacts()
    {
        return view('private_cabinet.profile.contacts', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
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
        $type = $request->get('type');

        $reviews = $this->profileService->getUserCompanyReviews($type);
        $user_company = $this->profileService->userHasCompany();
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
        $company = [];

        if (auth()->user()) {
            $user = auth()->user();
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
        if ($request->errors == null){
            $this->profileService->createOrUpdateCompany($request);
            return redirect()->route('user.profile.company');
        }

        return redirect()->back()->withInput($request->input())->withErrors($request->validated());
    }


    //Если есть созданая компания тогда + новая страница профиля (новости)
    public function profileNews()
    {
        return view('private_cabinet.profile.news', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[5],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //Если есть созданая компания тогда + новая страница профиля (вакансии)
    public function profileVacancy()
    {
        return view('private_cabinet.profile.vacancy', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[6],
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
