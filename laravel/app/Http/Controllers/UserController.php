<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewLoginRequest;
use App\Models\Comp\CompTgroups;
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
        $login = $this->profileService->getLogin();

        return view('private_cabinet.profile.profile', [
            'login' => $login,
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    // изменить пароль
    public function changePass(Request $request)
    {
        $user = User::where('id', Auth::id())->get()[0];
        $torg_buyer = TorgBuyer::where('id', $user->user_id)->get()[0];

        $old_pass = $request->get('oldPassword');
        $new_pass = $request->get('password');
        if (Hash::check($old_pass, $user->passwd) && $new_pass){
            $torg_buyer->passwd = bcrypt($new_pass);
            $torg_buyer->save();
            $user->passwd = bcrypt($new_pass);
            $user->save();
        }else {
            dd('no');
        }

    }


    // изменить login
    public function newLogin(NewLoginRequest $newLoginRequest)
    {
        $user = User::where('id', Auth::id())->get()[0];
        $torg_buyer = TorgBuyer::where('id', $user->user_id)->get()[0];
        $new_login = $newLoginRequest->get('email');

        $validate = $newLoginRequest->validated();
        if ($validate) {
            $torg_buyer->login = $new_login;
            $torg_buyer->email = $new_login;
            $torg_buyer->save();
            $user->login = $new_login;
            $user->email = $new_login;
            $user->save();
            return  redirect()->route('user.profile.profile')
                ->with(['success' => 'Email успешно изменен!']);
        }else {
            return redirect()->back()
                ->withInput($newLoginRequest->all())
                ->withErrors(['msg' => 'Ошибка']);
        }
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
    public function profileReviews()
    {
        return view('private_cabinet.profile.reviews', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[3],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы профиля (компании) ProfileCompanyRequest
    public function profileCompany(Request $request)
    {
        dump($request->validated());
        //$this->profileService->createCompany($request);
//        if($request->get('title') != null) {
//            $this->profileService->createCompany($request);
//        }

        $regions = $this->baseServices->getRegions()->forget(25);
        $rubrics = CompTgroups::with(['comp_topic' => function ($query) {
            $query->select('menu_group_id', 'title', 'id')->where('parent_id', 0);
        }])->orderBy('sort_num')->orderBy('title')->get();

        return view('private_cabinet.profile.company', [
            'regions' => $regions,
            'rubrics' => $rubrics,
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[4],
            'isMobile' => $this->agent->isMobile(),
        ]);
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
