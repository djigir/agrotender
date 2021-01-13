<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Comp\CompTgroups;
use App\Models\Torg\TorgBuyer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Column\Url;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Facades\FormElement;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\FormButton;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\Columns\Column;
use SleepingOwl\Admin\Section;


/**
 * Class CompItems
 *
 * @property \App\Models\Comp\CompItems $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompItems extends Section implements Initializable
{
    /* const for filter  */
    const TRADER_SELL = 100;
    const TRADER_BUYER = 200;

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Редактор компаний';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $request = \request();
        if(!empty($request->all())) {
            if($request->get('type') == 'active_traders'){
                $this->title = 'Активные трейды';
            }

            if($request->get('type') == 'traders'){
                $this->title = 'Трейдеры';
            }

            if($request->get('type') == 'email_company'){
                $this->title = 'Экспорт email компаний';
            }

        }

//        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $type = \request()->get('type');

        /* Экспрот Email компаний с фильтром */

        /* START EXPORT */
        if ($type == 'email_company'){
//            return AdminDisplay::datatables()->setName('firstdatatables')->setView('display.UnloadDownload.email_export_comapny');

            $rubriks = \App\Models\Comp\CompTopic::orderBy('menu_group_id')->get();
            $rubriks_gr = CompTgroups::all();

            $rubrik_select = [];
            /** @var CompTgroups $rubrik_gr */
            foreach ($rubriks_gr as $rubrik_gr) {
                /** @var \App\Models\Comp\CompTopic $rubrik */
                foreach ($rubriks as $rubrik) {
                    if ($rubrik->menu_group_id !== $rubrik_gr->id) {
                        continue;
                    }
                    $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
                }
            }


            $columns = [

                AdminColumn::custom('', function(\Illuminate\Database\Eloquent\Model $model) {
//                    return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
                })->setWidth('100px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable('id'),
                ];

            $display = AdminDisplay::datatables()
                ->setName('firstdatatables')
                ->setOrder([[0, 'desc']])
                ->setDisplaySearch(false)
                ->paginate(25)
                ->setColumns($columns)
                ->setHtmlAttribute('class', 'table-primary table-hover th-center');


            $display->setColumnFilters([
                AdminColumnFilter::select()
                    ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('name')
                    ->setColumnName('obl_id')
                    ->setHtmlAttributes([
                        'class' => ['obl_filter'],
                        'type_filter' => 'regions'
                    ])
                    ->setPlaceholder('Все Области'),


                AdminColumnFilter::select()
                    ->setModelForOptions(CompTgroups::class, 'title')
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title')
                    ->setColumnName('compTopicItem.topic_id')
                    ->setPlaceholder('Все секции')
                    ->setHtmlAttributes([
                        'class' => ['section_filter'],
                        'type_filter' => 'sections'
                    ])
                    ->addStyle('my', asset('/app/assets/css/my-laravel.css')),
            ]);


            $display->getColumnFilters()->setPlacement('card.heading');

            return $display;

        }
        /* END EXPORT */


        /* get type company */

        /* START TRADERS */

        if($type == 'traders'){

            $rubriks = \App\Models\Comp\CompTopic::orderBy('menu_group_id')->get();
            $rubriks_gr = CompTgroups::all();

            $rubrik_select = [];
            /** @var CompTgroups $rubrik_gr */
            foreach ($rubriks_gr as $rubrik_gr) {
                /** @var \App\Models\Comp\CompTopic $rubrik */
                foreach ($rubriks as $rubrik) {
                    if ($rubrik->menu_group_id !== $rubrik_gr->id) {
                        continue;
                    }
                    $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
                }
            }

            $columns = [

                AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                    return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
                })->setWidth('100px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable('id'),


                AdminColumn::image('logo_file', 'Лого'),

                AdminColumn::link('title', 'Компания')
                    ->setHtmlAttribute('class', 'text-center'),

                AdminColumn::text('torgBuyer.name', 'Ф.И.О')
                    ->setWidth('130px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable(function($query, $direction) {
                        $query->orderBy('id', $direction);
                    }),

                AdminColumn::text('torgBuyer.login', 'Логин')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable(function($query, $direction) {
                        $query->orderBy('id', $direction);
                    }),

                AdminColumn::text('region.name', 'Область')
                    ->setWidth('140px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable(function($query, $direction) {
                        $query->orderBy('obl_id', $direction);
                    }),

                AdminColumn::text('add_date', 'Дата рег./Последн. вход', 'torgBuyer.last_login')
                    ->setWidth('192px')
                    ->setHtmlAttribute('class', 'text-center'),

                AdminColumn::custom('T/З/У', function (\Illuminate\Database\Eloquent\Model $model) {
                    return "<a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=2&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 2)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=1&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 1)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=3&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 3)->count()}</a>
                        ";
                })->setWidth('80px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->addStyle('my', asset('/app/assets/css/my-laravel.css')),


                AdminColumn::text('rate_formula', 'Рейт.')
                    ->setWidth('65px')
                    ->setHtmlAttribute('class', 'text-center'),

                AdminColumn::text('rate', 'Посещений')
                    ->setWidth('110px')
                    ->setHtmlAttribute('class', 'text-center'),

                AdminColumn::text('buyerTarifPacks.title', 'Пакет')
                    ->setWidth('130px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable(function($query, $direction) {
                        $query->orderBy('id', $direction);
                    }),

                AdminColumn::count('compComment', 'Отзывов')
                    ->setWidth('83px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable(function($query, $direction) {
                        $query->orderBy('id', $direction);
                    }),

                AdminColumn::custom('Действие', function (\App\Models\Comp\CompItems $compItems){
                    return "<a href=".route('admin.login_as_user', ['user_id' => $compItems->author_id])." class='btn btn-success btn-sm'>Войти</a>";
                })->setWidth('126px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable('id'),

            ];


            $display = AdminDisplay::datatables()
                ->setApply(function ($query){
                    $query->where('trader_price_avail', 1);
                })
                ->setName('firstdatatables')
                ->setOrder([[0, 'desc']])
                ->setDisplaySearch(false)
                ->paginate(25)
                ->setColumns($columns)
                ->setHtmlAttribute('class', 'table-primary table-hover th-center');


            $display->setColumnFilters([
                AdminColumnFilter::select()
                    ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('name')
                    ->setColumnName('obl_id')
                    ->setPlaceholder('Все Области'),

                AdminColumnFilter::select()
                    ->setOptions($rubrik_select)
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title')
                    ->setColumnName('compTopicItem.topic_id')
                    ->setPlaceholder('Все секции'),


                \AdminColumnFilter::select()
                    ->setOptions([
                        self::TRADER_BUYER => 'Трейдер (закуп.)',
                        self::TRADER_SELL => 'Трейдер (продажи.)',
                    ])
                    ->setPlaceholder('Все компании')->setCallback(function( $value,$query,$v) {
                        $request = \request()->get('columns')[2]['search']['value'];

                        if ($request == 100){
                            $query->where('trader_price_sell_avail', 1);
                        }
                        if ($request == 200){
                            $query->where('trader_price_avail', 1);
                        }
                    }),

                AdminColumnFilter::text()
                    ->setColumnName('title')
                    ->setOperator('contains')
                    ->setPlaceholder('По названию компании'),

                AdminColumnFilter::text()
                    ->setColumnName('torgBuyer.login')
                    ->setPlaceholder('Фильтровать по E-mail'),

                AdminColumnFilter::text()
                    ->setColumnName('phone')
                    ->setHtmlAttribute('class', 'phone_search')
                    ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                    ->setPlaceholder('по Тел.'),

                AdminColumnFilter::text()
                    ->setHtmlAttribute('class', 'author_search')
                    ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                    ->setColumnName('torgBuyer.name')
                    ->setOperator('contains')
                    ->setPlaceholder('по Автору'),

                AdminColumnFilter::text()
                    ->setHtmlAttribute('class', 'ID_search')
                    ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                    ->setColumnName('id')
                    ->setPlaceholder('по ID'),

            ]);


            $display->getColumnFilters()->setPlacement('card.heading');

            return $display;
        }
        /* END TRADERS */


        /* START ACTIVE TRADERS */
        $type = \request()->get('type');

        if($type == 'active_traders'){

            $rubriks = \App\Models\Comp\CompTopic::orderBy('menu_group_id')->get();
            $rubriks_gr = CompTgroups::all();

            $rubrik_select = [];
            /** @var CompTgroups $rubrik_gr */
            foreach ($rubriks_gr as $rubrik_gr) {
                /** @var \App\Models\Comp\CompTopic $rubrik */
                foreach ($rubriks as $rubrik) {
                    if ($rubrik->menu_group_id !== $rubrik_gr->id) {
                        continue;
                    }
                    $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
                }
            }

            $columns = [

                AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                    return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
                })->setWidth('100px')
                    ->setHtmlAttribute('class', 'text-center')
                    ->setOrderable('id'),


                AdminColumn::image('logo_file', 'Лого'),

                AdminColumn::link('title', 'Название')
                    ->setHtmlAttribute('class', 'text-center'),

                AdminColumn::custom('Таблица закупок', function (\App\Models\Comp\CompItems $compItems){
                    $table = 'Да';
                    $compItems->trader_price_visible == 1 ? $table = 'Нет' : $table = 'Да';
                    $table == 'Да' ? $issetLink = "color: currentColor; opacity: 0.5; text-decoration: none;" : $issetLink = '';
                    return "<a href=".route('company.index', ['id_company' => $compItems->id])." class='btn btn-success btn-sm' style='{$issetLink}' target='_blank'>Посмотреть</a>";
                })->setHtmlAttribute('class', 'text-center'),

                AdminColumn::custom('Таблица Скрыта', function(\Illuminate\Database\Eloquent\Model $model) {
                    $table = 'Да';
                    $style = 'color:green';

                    $model->trader_price_visible == 1 ? $table = 'Нет' : $table = 'Да';
                    $table == 'Нет' ? $style = 'color:green' : $style = 'color:red';

                    return "<div class='row-text text-center' style='{$style}'>
                                {$table}
                            </div>";
                })->setHtmlAttribute('class', 'text-center'),


                AdminColumn::custom('Последнее обновление', function(\Illuminate\Database\Eloquent\Model $model){
                    $last_update = \DB::table('traders_prices')->where('buyer_id', $model->author_id)->max('dt');
                    return $last_update;
                })->setHtmlAttribute('class', 'text-center'),

                AdminColumn::custom('Дней назад', function (\Illuminate\Database\Eloquent\Model $model) {
                    $last_update = \DB::table('traders_prices')->where('buyer_id', $model->author_id)->max('dt');
                    $d = Carbon::parse($last_update);
                    $now = Carbon::now();
                    return $d->diffInDays($now);
                })->setHtmlAttribute('class', 'text-center'),

            ];

            $display = AdminDisplay::datatables()
                ->setApply(function ($query){
                    $query->where('trader_price_avail',1);
                })
                ->setName('firstdatatables')
                ->setOrder([[0, 'desc']])
                ->setDisplaySearch(false)
                ->paginate(25)
                ->setColumns($columns)
                ->setHtmlAttribute('class', 'table-primary table-hover th-center');


            $display->setColumnFilters([
                AdminColumnFilter::select()
                    ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('name')
                    ->setColumnName('obl_id')
                    ->setPlaceholder('Все Области'),


                AdminColumnFilter::text()
                    ->setColumnName('title')
                    ->setOperator('contains')
                    ->setPlaceholder('По названию компании'),


                AdminColumnFilter::text()
                    ->setHtmlAttribute('class', 'ID_search')
                    ->setColumnName('id')
                    ->setPlaceholder('по ID'),

            ]);

            $display->getColumnFilters()->setPlacement('card.heading');

            return $display;
        }
        /* END ACTIVE TRADERS */



        /* COMPANY EDIT */

        $rubriks = \App\Models\Comp\CompTopic::orderBy('menu_group_id')->get();
        $rubriks_gr = CompTgroups::all();

        $rubrik_select = [];
        /** @var CompTgroups $rubrik_gr */
        foreach ($rubriks_gr as $rubrik_gr) {
            /** @var \App\Models\Comp\CompTopic $rubrik */
            foreach ($rubriks as $rubrik) {
                if ($rubrik->menu_group_id !== $rubrik_gr->id) {
                    continue;
                }
                $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
            }
        }

        $columns = [

            AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
            })->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable('id'),


            AdminColumn::image('logo_file', 'Лого'),

            AdminColumn::link('title', 'Компания')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.name', 'Ф.И.О')
                ->setWidth('130px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::text('torgBuyer.login', 'Логин')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::text('region.name', 'Область')
                ->setWidth('140px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('obl_id', $direction);
                }),

            AdminColumn::text('add_date', 'Дата рег./Последн. вход', 'torgBuyer.last_login')
                ->setWidth('192px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('T/З/У', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=2&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 2)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=1&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 1)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=3&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 3)->count()}</a>
                        ";
            })->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css')),


            AdminColumn::text('rate_formula', 'Рейт.')
                ->setWidth('65px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('rate', 'Посещений')
                ->setWidth('110px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('buyerTarifPacks.title', 'Пакет')
                ->setWidth('130px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::count('compComment', 'Отзывов')
                ->setWidth('83px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::custom('Действие', function (\App\Models\Comp\CompItems $compItems){
                return "<a href=".route('admin.login_as_user', ['user_id' => $compItems->author_id])." class='btn btn-success btn-sm'>Войти</a>";
            })->setWidth('126px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable('id'),

        ];


        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');


        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setPlaceholder('Все Области'),

            AdminColumnFilter::select()
                ->setOptions($rubrik_select)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('title')
                ->setColumnName('compTopicItem.topic_id')
                ->setPlaceholder('Все секции'),


            \AdminColumnFilter::select()
                ->setOptions([
                    self::TRADER_BUYER => 'Трейдер (закуп.)',
                    self::TRADER_SELL => 'Трейдер (продажи.)',
                ])
                ->setPlaceholder('Все компании')->setCallback(function( $value,$query,$v) {
                    $request = \request()->get('columns')[2]['search']['value'];

                    if ($request == 100){
                        $query->where('trader_price_sell_avail', 1);
                    }
                    if ($request == 200){
                        $query->where('trader_price_avail', 1);
                    }
                }),

            AdminColumnFilter::text()
                ->setColumnName('title')
                ->setOperator('contains')
                ->setPlaceholder('По названию компании'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.login')
                ->setPlaceholder('Фильтровать по E-mail'),

            AdminColumnFilter::text()
                ->setColumnName('phone')
                ->setHtmlAttribute('class', 'phone_search')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                ->setPlaceholder('по Тел.'),

            AdminColumnFilter::text()
                ->setHtmlAttribute('class', 'author_search')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                ->setColumnName('torgBuyer.name')
                ->setOperator('contains')
                ->setPlaceholder('по Автору'),

            AdminColumnFilter::text()
                ->setHtmlAttribute('class', 'ID_search')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                ->setColumnName('id')
                ->setPlaceholder('по ID'),

        ]);

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;

    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title', 'Название')
                    ->required(),

                AdminFormElement::image('logo_file', 'Лого')->setReadonly(true),

                AdminFormElement::html('<span>Таблица закупок:</span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::select('trader_price_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                ]),

                AdminFormElement::select('trader_premium', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                        2 => 'Премиум +'
                ]),

                AdminFormElement::number('trader_sort', 'Приоретет'),
                AdminFormElement::html('<hr>'),
                AdminFormElement::html('<span>Таблица продаж:</span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::select('trader_price_sell_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('trader_premium_sell', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                        2 => 'Премиум +'
                    ]),

                AdminFormElement::number('trader_sort_sell', 'Приоретет'),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                AdminFormElement::html('<span>Таблица форвардов:</span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::select('trader_price_forward_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('trader_premium_forward', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::number('trader_sort_forward', 'Приоретет'),
                AdminFormElement::html('<hr>'),


                AdminFormElement::select('site_pack_id', 'Пакет размещения')
                    ->setModelForOptions(BuyerTarifPacks::class)
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title'),

                AdminFormElement::number('rate_admin1', 'К рейтинга Admin1'),
                AdminFormElement::number('rate_admin2', 'К рейтинга Admin2'),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    /*public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }*/

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        $type = \request()->get('type');
        if ($type == 'email_company') {
            return  false;
        }
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
