<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Comp\CompTgroups;
use Carbon\Carbon;
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
    const TRADER_SELL = 100;
    const TRADER_BUYER = 200;
    const PACKAGES = [
        0 => 'Стандарт',
        1 => 'Премиум',
        2 => 'ТОП',
    ];

    const PACKAGES_STYLE = [
        0 => 'black',
        1 => '#dda216',
        2 => '#b6581b',
    ];


    protected $per_page = 25;

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
    protected $title_comp = '';

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

    public function getEditTitle()
    {
        return "Редактировать {$this->title_comp}";
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
        $per_page = (int)request()->get("paginate") == 0 ? 25 : (int)request()->get("paginate");
        $columns = [
            AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
            })->setWidth('90px')->setHtmlAttribute('class', 'text-center')->setOrderable('id'),

            AdminColumn::image('logo_file', 'Лого')->setImageWidth('48px'),
            AdminColumn::link('title', 'Компания/Имя', 'torgBuyer.name')->setOrderable('title')->setWidth('160px'),
            AdminColumn::text('torgBuyer.email', 'E-mail')->setWidth('160px')->setOrderable(false),

            AdminColumn::custom('Пакет', function (\App\Models\Comp\CompItems $compItems){
                $package = $compItems->trader_premium != 0 ? '<b>'.self::PACKAGES[$compItems->trader_premium].'</b>' : self::PACKAGES[$compItems->trader_premium];
                $color = self::PACKAGES_STYLE[$compItems->trader_premium];
                return "<div style='color: $color' class='row-custom text-center'>{$package}</div>";
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center')->setOrderable('trader_premium'),

            AdminColumn::custom('Начало пакета', function (\Illuminate\Database\Eloquent\Model $model){
                $package = !$model['torgBuyer']['buyerPacksOrders']->isEmpty() ? Carbon::parse($model['torgBuyer']['buyerPacksOrders']->max('stdt'))->format('Y-m-d') : '';
                return "<div class='row-text text-center'>{$package}</div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center')
                ->setOrderCallback(function($column, $query, $direction){
                    $query->leftJoin('torg_buyer', 'comp_items.author_id', '=', 'torg_buyer.id')
                        ->leftJoin('buyer_packs_orders', 'torg_buyer.id', '=', 'buyer_packs_orders.user_id')
                        ->select('comp_items.*', \DB::raw('max(agt_buyer_packs_orders.stdt) AS orders_stdt'))
                        ->groupBy('comp_items.id')
                        ->orderBy('orders_stdt', $direction);
            }),

            AdminColumn::custom('Окончание пакета', function (\Illuminate\Database\Eloquent\Model $model){
                $package = !$model['torgBuyer']['buyerPacksOrders']->isEmpty() ? Carbon::parse($model['torgBuyer']['buyerPacksOrders']->max('endt'))->format('Y-m-d') : '';
                return "<div class='row-text text-center'>{$package}</div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center')
                ->setOrderCallback(function($column, $query, $direction){
                    $query->leftJoin('torg_buyer', 'comp_items.author_id', '=', 'torg_buyer.id')
                        ->leftJoin('buyer_packs_orders', 'torg_buyer.id', '=', 'buyer_packs_orders.user_id')
                        ->select('comp_items.*', \DB::raw('max(agt_buyer_packs_orders.endt) AS orders_endt'))
                        ->groupBy('comp_items.id')
                        ->orderBy('orders_endt', $direction);
            }),
        ];


        $display = AdminDisplay::datatables()
            ->setApply(function ($query){
                $query->where('trader_price_avail', 1);
            })
            ->setName('firstdatatables')
            ->setOrder([[1, 'desc']])
            ->setDisplaySearch(false)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                    $query->where('id', $value);
                }),

                AdminDisplayFilter::custom('phone')->setCallback(function ($query, $value) {
                    $query->where('phone', $value);
                }),

                AdminDisplayFilter::custom('title')->setCallback(function ($query, $value) {
                    $query->where('title', 'like', '%' . $value . '%');
                }),

                AdminDisplayFilter::custom('email')->setCallback(function ($query, $value) {
                    $query->whereHas('torgBuyer', function ($query) use ($value) {
                        $query->where('login', $value);
                    });
                })
            );

        $display->getColumnFilters()->setPlacement('card.heading');

        $button = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $WWWHOST = 'https://agrotender.com.ua/';
            return $WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($model['torgBuyer']['login'])."&buyerpass=".stripslashes($model['torgBuyer']['passwd']);
        }, '', 50);

        $button->setIcon('fas fa-user-lock');
        $button->setHtmlAttributes(['target' => '_blank', 'class' => 'btn-success btn btn-xs']);

        $display->getColumns()->getControlColumn()->addButton($button);

        return $display->paginate($per_page);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $this->title_comp = $this->model_value['title'];
        $url = \Str::before(\Request::url(), '/ad')."/admin_dev/torg_buyers/{$this->model_value['torgBuyer']['id']}/edit";

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::html("<br>
                <a href='{$url}' target='_blank' class='btn btn-primary'>Пользователь</a><br><br>"),
                AdminFormElement::text('title', 'Название')->required(),
                AdminFormElement::image('logo_file', 'Лого')->setReadonly(true),

                AdminFormElement::html('<span><b>Таблица закупок:</b></span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::columns()->addColumn([
                    AdminFormElement::select('trader_price_avail', 'Активна')->setOptions([0 => 'Нет', 1 => 'Да']),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                    AdminFormElement::select('trader_premium', 'Премиум')->setOptions([0 => 'Нет', 1 => 'Да', 2 => 'Топ']),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),

                AdminFormElement::html('<span><b>Таблица форвардов:</b></span><br><br>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::columns()->addColumn([
                    AdminFormElement::select('trader_price_forward_avail', 'Активна')->setOptions([0 => 'Нет', 1 => 'Да',]),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                    AdminFormElement::select('trader_premium_forward', 'Премиум')->setOptions([0 => 'Нет', 1 => 'Да',]),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),


                AdminFormElement::html('<span><b>Пакеты:</b></span>'),
                AdminFormElement::html('<hr>'),
                AdminFormElement::columns()->addColumn([
                    AdminFormElement::datetime('buyerPacksOrdersStart.stdt', 'Начало пакета')->setFormat('Y-m-d'),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                    AdminFormElement::datetime('buyerPacksOrdersEnd.endt', 'Окончание пакета')->setFormat('Y-m-d'),
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),

            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-4')
        ]);

        $form->getButtons()->setButtons([
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
     * @param Model $model
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
