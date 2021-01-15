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
        \App\Models\Comp\CompItemsActive::class => 'App\Http\Sections\FastAccess\ActiveTraders',
        \App\Models\Comp\CompItemsTraders::class => 'App\Http\Sections\FastAccess\Traders',

                                /* Цены трейдеров */
        \App\Models\Traders\TradersProducts::class => 'App\Http\Sections\TraderPrices\TradersProducts',
        \App\Models\Seo\SeoTitles::class => 'App\Http\Sections\TraderPrices\SeoTitlesTrades',
        \App\Models\Traders\TradersPorts::class => 'App\Http\Sections\TraderPrices\TradersPorts',
        \App\Models\Traders\TradersProductsSell::class => 'App\Http\Sections\TraderPrices\TradersProductsSell',
        \App\Models\Traders\TradersProductGroups::class => 'App\Http\Sections\TraderPrices\TradersProductGroups',




                    /* Управление пользователями user management */
        \App\Models\Users\Users::class => 'App\Http\Sections\UsersAdmin',
        \App\Models\Torg\TorgBuyer::class => 'App\Http\Sections\UserManagement\TorgBuyer',
        \App\Models\Py\PyBalance::class => 'App\Http\Sections\UserManagement\PyBalance',
        \App\Models\Py\PyBill::class => 'App\Http\Sections\UserManagement\PyBill',
        \App\Models\Py\PyBillDoc::class => 'App\Http\Sections\UserManagement\PyBillDoc',
        \App\Models\Torg\TorgBuyerBan::class => 'App\Http\Sections\UserManagement\TorgBuyerBan',
        \App\Models\Buyer\BuyerPacksOrders::class => 'App\Http\Sections\UserManagement\BuyerPacksOrders',


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
        \App\Models\ADV\AdvTorgTopic::class => 'App\Http\Sections\Board\AdvTorgTopic',
        \App\Models\Seo\SeoTitlesBoard::class => 'App\Http\Sections\Board\SeoTitlesBoard',


                                        /* Компании */
        \App\Models\Comp\CompTopic::class => 'App\Http\Sections\Companies\CompTopic',
        \App\Models\Comp\CompNews::class => 'App\Http\Sections\Companies\CompNews',
        \App\Models\Comp\CompVacancy::class => 'App\Http\Sections\Companies\CompVacancy',
        \App\Models\Comp\CompTgroups::class => 'App\Http\Sections\Companies\CompTgroups',
        \App\Models\Comp\CompComment::class => 'App\Http\Sections\Companies\CompComment',
        \App\Models\Comp\CompCommentComplains::class => 'App\Http\Sections\Companies\CompCommentComplains',


                                    /* Управление алгоритмами */
        \App\Models\Preferences\Preferences::class => 'App\Http\Sections\AlgorithmManagement\Preferences',
        \App\Models\Resource\Resource::class => 'App\Http\Sections\AlgorithmManagement\Resource',
        \App\Models\Contact\ContactOptions::class => 'App\Http\Sections\AlgorithmManagement\ContactOptions',
        \App\Models\Buyer\BuyerTarifPacks::class => 'App\Http\Sections\AlgorithmManagement\BuyerTarifPacks',


                                        /* Управление страницами */
        \App\Models\Pages\Pages::class => 'App\Http\Sections\PagesManagement\Pages',
        \App\Models\Popup\PopupDlgs::class => 'App\Http\Sections\PagesManagement\PopupDlgs',


                                                /* Реклама */
        \App\Models\Banner\BannerPlaces::class => 'App\Http\Sections\Advertising\BannerPlaces',
        \App\Models\Banner\BannerRotate::class => 'App\Http\Sections\Advertising\BannerRotate',

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
