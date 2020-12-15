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

            /* Управление пользователями */
        \App\Models\Users\Users::class => 'App\Http\Sections\UsersAdmin',

            /* Быстрый доступ */
        \App\Models\Elevators\TorgElevator::class => 'App\Http\Sections\TorgElevator',

            /* Новости/Библиотека */
        \App\Models\News\News::class => 'App\Http\Sections\News\AgtNews',
        \App\Models\News\NewsComment::class => 'App\Http\Sections\News\AgtNewsComment',

            /* Доска объявлений */
        \App\Models\ADV\AdvSearch::class => 'App\Http\Sections\Search\AdvSearch',

            /* Компании */
        \App\Models\Comp\CompTopic::class => 'App\Http\Sections\Companies\CompTopic',
        \App\Models\Comp\CompNews::class => 'App\Http\Sections\Companies\CompNews',


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
