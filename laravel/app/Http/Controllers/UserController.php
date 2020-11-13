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
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (уведомления)
    public function profile_notify()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    //М-д для страницы профиля (отзывы)
    public function profile_reviews()
    {

    }

    //М-д для страницы профиля (компании)
    public function profile_company()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы объявления
    public function advert()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/лимитивные тарифы
    public function advert_limits()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-д для страницы тарифы/улучшения обьявлений
    public function advert_upgrade()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/поплнить балансе
    public function balance_pay()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/история платежей
    public function balance_history()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы тарифы/счета-акты
    public function balance_docs()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    //М-ды для страницы заявки
    public function applications()
    {
        return view('', [
            'isMobile' => $this->agent->isMobile(),
        ]);
    }
}
