<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    ];

    const TYPE_PAGE_TARIFF = [
        0 => 'advert_limit',
        1 => 'advert_upgrade',
        2 => 'balance_pay',
        3 => 'balance_history',
        4 => 'balance_docs',
    ];


    protected $agent;


    public function __construct()
    {
        $this->agent = new \Jenssegers\Agent\Agent;
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

    //М-д для страницы профиля (контакты)
    public function profile_contacts()
    {
        return view('private_cabinet.profile.contacts', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (уведомления)
    public function profile_notify()
    {
        return view('private_cabinet.profile.notify', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (отзывы)
    public function profile_reviews()
    {
        return view('private_cabinet.profile.reviews', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[3],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (компании)
    public function profile_company()
    {
        return view('private_cabinet.profile.company', [
            'type_page' => self::TYPE_PAGE[0],
            'type_page_profile' => self::TYPE_PAGE_PROFILE[4],
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
    public function advert_limit()
    {
        return view('private_cabinet.advert.limits', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[0],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/улучшения обьявлений
    public function advert_upgrade()
    {
        return view('private_cabinet.advert.upgrade', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[1],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/поплнить балансе
    public function balance_pay()
    {
        return view('private_cabinet.tariff.balance_pay', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[2],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/история платежей
    public function balance_history()
    {
        return view('private_cabinet.tariff.balance_history', [
            'type_page' => self::TYPE_PAGE[3],
            'type_page_tariff' => self::TYPE_PAGE_TARIFF[3],
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/счета-акты
    public function balance_docs()
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
