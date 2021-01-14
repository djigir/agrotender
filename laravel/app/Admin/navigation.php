<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
//    [
//        'title' => 'Dashboard',
//        'icon'  => 'fas fa-tachometer-alt',
//        'url'   => route('admin.dashboard'),
//    ],

//    [
//        'title' => 'Information',
//        'icon'  => 'fas fa-info-circle',
//        'url'   => route('admin.information'),
//    ],


    [
        'title' => 'Быстрый доступ',
        'icon' => 'fas fa-tachometer-alt',

        'pages' => [
            (new Page(\App\Models\Comp\CompItemsTraders::class))
                ->setIcon('fa fa-fax')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompItemsActive::class))
                ->setIcon('fa fa-fax')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompItems::class))
                ->setIcon('fa fa-fax')
                ->setPriority(0),

            (new Page(\App\Models\Elevators\TorgElevator::class))
                ->setIcon('fas fa-warehouse')
                ->setPriority(0),

            (new Page(\App\Models\Lenta\Lenta::class))
                ->setIcon('fas fa-scroll')
                ->setPriority(0),

            (new Page(\App\Models\ADV\AdvTorgPost::class))
                ->setIcon('fas fa-ad')
                ->setPriority(0),
        ],

    ],

    [
        'title' => 'Доска объявлений',
        'icon' => 'fas fa-clipboard-list',

        'pages' => [

            (new Page(\App\Models\ADV\AdvTorgTgroups::class))
            ->setIcon('fas fa-clipboard')
            ->setPriority(0),

            (new Page(\App\Models\ADV\AdvTorgPostComplains::class))
                ->setIcon('fas fa-minus-circle')
                ->setPriority(0),

            (new Page(\App\Models\ADV\AdvSearch::class))
                ->setIcon('fas fa-question')
                ->setPriority(0),

            (new Page(\App\Models\ADV\AdvWordTopic::class))
                ->setIcon('fas fa-info')
                ->setPriority(0),

            (new Page(\App\Models\ADV\AdvTorgTopic::class))
                ->setIcon('fas fa-info')
                ->setPriority(0),

            (new Page(\App\Models\Seo\SeoTitlesBoard::class))
                ->setIcon('far fa-building')
                ->setPriority(0),

        ]
    ],

    [
        'title' => 'Компании',
        'icon' => 'fas fa-building',

        'pages' => [

            (new Page(\App\Models\Comp\CompTgroups::class))
                ->setIcon('fas fa-layer-group')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompTopic::class))
                ->setIcon('fas fa-layer-group')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompNews::class))
                ->setIcon('fas fa-file')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompVacancy::class))
                ->setIcon('fas fa-briefcase')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompComment::class))
                ->setIcon('fas fa-comments')
                ->setPriority(0),

            (new Page(\App\Models\Comp\CompCommentComplains::class))
                ->setIcon('fas fa-ban')
                ->setPriority(0),



        ]
    ],

    [
        'title' => 'Цены трейдеров',
        'icon' => 'fas fa-dollar-sign',

        'pages' => [

            (new Page( \App\Models\Traders\TradersProducts::class))
                ->setIcon('fab fa-product-hunt')
                ->setPriority(0),

            [
                'title' => 'Закупки',
                'icon'  => 'fas fa-shopping-basket',
                'url'   => '/admin_dev/traders_products?type=sell',
            ],

            (new Page(\App\Models\Seo\SeoTitles::class))
                ->setIcon('fas fa-tasks')
                ->setPriority(0),

            (new Page(\App\Models\Traders\TradersPorts::class))
                ->setIcon('fas fa-anchor')
                ->setPriority(0),
        ]
    ],


    [
        'title' => 'Новости/Библиотека',
        'icon' => 'fas fa-newspaper',

        'pages' => [

            (new Page( \App\Models\News\News::class))
                ->setIcon('fas fa-file')
                ->setPriority(0),

            (new Page( \App\Models\News\NewsComment::class))
                ->setIcon('fas fa-comments')
                ->setPriority(0),

        ]
    ],

    /* Пока не надо сказал заказчик */
    /*[
        'title' => 'Элеваторы',
        'icon' => 'fas fa-warehouse',

        'pages' => [


        ]
    ],*/

    [
        'title' => 'Управление пользователями',
        'icon' => 'fas fa-users',

        'pages' => [

            (new Page(     \App\Models\Torg\TorgBuyer::class))
                ->setIcon('fas fa-user')
                ->setPriority(0),

            (new Page(     \App\Models\Py\PyBalance::class))
                ->setIcon('fas fa-money-bill-alt')
                ->setPriority(0),

            (new Page(     \App\Models\Py\PyBill::class))
                ->setIcon('fas fa-money-check-alt')
                ->setPriority(0),

            (new Page(     \App\Models\Users\Users::class))
                ->setIcon('fas fa-user-tie')
                ->setPriority(0),

            (new Page(\App\Models\Torg\TorgBuyerBan::class))
                ->setIcon('fas fa-ban')
                ->setPriority(0),

            (new Page(\App\Models\Buyer\BuyerPacksOrders::class))
                ->setIcon('fas fa-box-open')
                ->setPriority(0),

            (new Page(\App\Models\Py\PyBillDoc::class))
                ->setIcon('fas fa-box-open')
                ->setPriority(0),
        ]
    ],

    [
        'title' => 'Управление алгоритмами',
        'icon' => 'fas fa-project-diagram',

        'pages' => [

            (new Page(     \App\Models\Preferences\Preferences::class))
                ->setIcon('fas fa-user')
                ->setPriority(0),

            (new Page(     \App\Models\Resource\Resource::class))
                ->setIcon('fas fa-align-justify')
                ->setPriority(1),

            (new Page(     \App\Models\Contact\ContactOptions::class))
                ->setIcon('fas fa-phone-alt')
                ->setPriority(2),

            (new Page(     \App\Models\Buyer\BuyerTarifPacks::class))
                ->setIcon('fas fa-user')
                ->setPriority(3),
        ]
    ],

    [
        'title' => 'Управление страницами',
        'icon' => 'fas fa-project-diagram',

        'pages' => [

            (new Page(     \App\Models\Pages\Pages::class))
                ->setIcon('fas fa-user')
                ->setPriority(0),

            (new Page(     \App\Models\Popup\PopupDlgs::class))
                ->setIcon('fas fa-user')
                ->setPriority(1),
        ]
    ],

    [
        'title' => 'Реклама',
        'icon' => 'fab fa-buysellads',

        'pages' => [

            (new Page(     \App\Models\Banner\BannerPlaces::class))
                ->setIcon('fab fa-buysellads')
                ->setPriority(0),
        ]
    ],


        /* Пока не надо сказал заказчик */
//    [
//        'title' => 'Выгрузка/Загрузка',
//        'icon' => 'fas fa-file-download',
//
//        'pages' => [
//
//            'pages' => [
//
//                'title' => 'Выгрузить телефоны',
//                'icon'  => 'fas fa-phone-alt',
//                'url'   => '/admin_dev/torg_buyers?type=download_phones',
//
//            ],
//
//            [
//                'title' => 'Экспорт Email компаниий',
//                'icon'  => 'fas fa-envelope',
//                'url'   => '/admin_dev/comp_items?type=email_company',
//
//            ],
//
//            [
//                'title' => 'Экспорт Email объявлений',
//                'icon'  => 'far fa-envelope',
//                'url'   => '/admin_dev/torg_buyers?type=email_adverts',
//
//            ],
//
//            [
//                'title' => 'Импорт Элеваторов',
//                'icon'  => 'far fa-envelope',
//                'url'   => '/admin_dev/torg_elevators?type=import_elev',
//            ]
//
//        ]
//    ],









    // Examples
    // [
    //    'title' => 'Content',
    //    'pages' => [
    //
    //        \App\User::class,
    //
    //        // or
    //
    //        (new Page(\App\User::class))
    //            ->setPriority(100)
    //            ->setIcon('fas fa-users')
    //            ->setUrl('users')
    //            ->setAccessLogic(function (Page $page) {
    //                return auth()->user()->isSuperAdmin();
    //            }),
    //
    //        // or
    //
    //        new Page([
    //            'title'    => 'News',
    //            'priority' => 200,
    //            'model'    => \App\News::class
    //        ]),
    //
    //        // or
    //        (new Page(/* ... */))->setPages(function (Page $page) {
    //            $page->addPage([
    //                'title'    => 'Blog',
    //                'priority' => 100,
    //                'model'    => \App\Blog::class
	//		      ));
    //
	//		      $page->addPage(\App\Blog::class);
    //	      }),
    //
    //        // or
    //
    //        [
    //            'title'       => 'News',
    //            'priority'    => 300,
    //            'accessLogic' => function ($page) {
    //                return $page->isActive();
    //		      },
    //            'pages'       => [
    //
    //                // ...
    //
    //            ]
    //        ]
    //    ]
    // ]
];
