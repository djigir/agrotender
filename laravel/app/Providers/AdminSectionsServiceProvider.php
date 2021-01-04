<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
//        \App\Models\Users\User::class => 'App\Http\Sections\Users\Users',

            /* Быстрый Доступ  Fast access */
        \App\Models\Lenta\Lenta::class => 'App\Http\Sections\FastAccess\Lenta',
        \App\Models\Comp\CompItems::class => 'App\Http\Sections\FastAccess\CompItems',
        \App\Models\ADV\AdvTorgPost::class => 'App\Http\Sections\FastAccess\AdvTorgPost',

        /* Цены трейдеров */
        \App\Models\Traders\TradersProducts::class => 'App\Http\Sections\TraderPrices\TradersProducts',
        \App\Models\Seo\SeoTitles::class => 'App\Http\Sections\TraderPrices\SeoTitlesTrades',


            /* Управление пользователями user management */
        \App\Models\Users\Users::class => 'App\Http\Sections\UsersAdmin',
        \App\Models\Torg\TorgBuyer::class => 'App\Http\Sections\UserManagement\TorgBuyer',
        \App\Models\Py\PyBalance::class => 'App\Http\Sections\UserManagement\PyBalance',
        \App\Models\Py\PyBill::class => 'App\Http\Sections\UserManagement\PyBill',
        \App\Models\Torg\TorgBuyerBan::class => 'App\Http\Sections\UserManagement\TorgBuyerBan',

            /* Быстрый доступ */
        \App\Models\Elevators\TorgElevator::class => 'App\Http\Sections\TorgElevator',

            /* Новости/Библиотека */
        \App\Models\News\News::class => 'App\Http\Sections\News\AgtNews',
        \App\Models\News\NewsComment::class => 'App\Http\Sections\News\AgtNewsComment',

            /* Доска объявлений  board */
        \App\Models\ADV\AdvSearch::class => 'App\Http\Sections\Board\AdvSearch',
        \App\Models\ADV\AdvTorgTgroups::class => 'App\Http\Sections\Board\AdvTorgTgroups',
        \App\Models\ADV\AdvTorgPostComplains::class => 'App\Http\Sections\Board\AdvTorgPostComplains',

        \App\Models\ADV\AdvWordTopic::class => 'App\Http\Sections\Board\AdvWordTopic',

            /* Компании */
        \App\Models\Comp\CompTopic::class => 'App\Http\Sections\Companies\CompTopic',
        \App\Models\Comp\CompNews::class => 'App\Http\Sections\Companies\CompNews',
        \App\Models\Comp\CompVacancy::class => 'App\Http\Sections\Companies\CompVacancy',
        \App\Models\Comp\CompTgroups::class => 'App\Http\Sections\Companies\CompTgroups',
        \App\Models\Comp\CompComment::class => 'App\Http\Sections\Companies\CompComment',
        \App\Models\Comp\CompCommentComplains::class => 'App\Http\Sections\Companies\CompCommentComplains',





    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
