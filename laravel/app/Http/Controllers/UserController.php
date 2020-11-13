<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $agent;


    public function __construct()
    {
        $this->agent = new \Jenssegers\Agent\Agent;
    }

    //М-д для страницы профиля (авторизация)
    public function profile()
    {
        return view('private_cabinet.profile.profile', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (контакты)
    public function profile_contacts()
    {
        return view('private_cabinet.profile.contacts', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (уведомления)
    public function profile_notify()
    {
        return view('private_cabinet.profile.notify', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (отзывы)
    public function profile_reviews()
    {
        return view('private_cabinet.profile.reviews', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (компании)
    public function profile_company()
    {
        return view('private_cabinet.profile.company', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы объявления
    public function advert()
    {
        return view('private_cabinet.advert.advert', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/лимитивные тарифы
    public function advert_limit()
    {
        return view('private_cabinet.advert.limits', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/улучшения обьявлений
    public function advert_upgrade()
    {
        return view('private_cabinet.advert.upgrade', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/поплнить балансе
    public function balance_pay()
    {
        return view('private_cabinet.tariff.balance_pay', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/история платежей
    public function balance_history()
    {
        return view('private_cabinet.tariff.balance_history', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/счета-акты
    public function balance_docs()
    {
        return view('private_cabinet.tariff.balance_docs', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы заявки
    public function applications()
    {
        return view('private_cabinet.application.application', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }
}
