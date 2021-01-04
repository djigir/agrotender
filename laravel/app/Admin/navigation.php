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
            [
                'title' => 'Активные Трейдеры',
                'icon'  => 'fas fa-building',
                'url'   => '/admin_dev/comp_items?type=active_traders',
            ],

            [
                'title' => 'Трейдеры',
                'icon'  => 'far fa-building',
                'url'   => '/admin_dev/comp_items?type=traders',

            ],

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
            ]
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

    [
        'title' => 'Элеваторы',
        'icon' => 'fas fa-warehouse',

        'pages' => [


        ]
    ],

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

        ]
    ],










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
