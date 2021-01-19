<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Comp\CompTgroups;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class Traders
 *
 * @property \App\Models\Comp\CompItemsTraders $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Traders extends Section implements Initializable
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
    protected $title = 'Трейдеры';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
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
            })->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable('id'),

            AdminColumn::image('logo_file', 'Лого')->setWidth('50px'),

            AdminColumn::link('title', 'Компания')
                ->setWidth('110px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.name', 'Ф.И.О')
                ->setWidth('140px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::text('torgBuyer.login', 'Логин')
                ->setWidth('110px')
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
                ->setWidth('195px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('T/З/У', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=2&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 2)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=1&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 1)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=3&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 3)->count()}</a>
                        ";
            })->setWidth('110px')
                ->setHtmlAttribute('class', 'text-center')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css')),

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
                ->setWidth('90px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::custom('Действие', function (\App\Models\Comp\CompItems $compItems){
                $WWWHOST = 'https://agrotender.com.ua/';
                return "<a href=\"".$WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($compItems['torgBuyer']['login'])."&buyerpass=".stripslashes($compItems['torgBuyer']['passwd'])."\" target='_blank' class='btn btn-success btn-sm'>Войти</a>";
            })->setWidth('150px')
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

//                AdminFormElement::number('trader_sort', 'Приоретет'),

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

//                AdminFormElement::number('trader_sort_sell', 'Приоретет'),
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

//                AdminFormElement::number('trader_sort_forward', 'Приоретет'),
                AdminFormElement::html('<hr>'),


                AdminFormElement::select('site_pack_id', 'Пакет размещения')
                    ->setModelForOptions(BuyerTarifPacks::class)
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title'),

//                AdminFormElement::number('rate_admin1', 'К рейтинга Admin1'),
//                AdminFormElement::number('rate_admin2', 'К рейтинга Admin2'),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

//    /**
//     * @return FormInterface
//     */
//    public function onCreate($payload = [])
//    {
//        return $this->onEdit(null, $payload);
//    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
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
