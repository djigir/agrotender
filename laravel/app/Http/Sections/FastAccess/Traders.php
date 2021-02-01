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
        $per_page = (int)request()->get("paginate") == 0 ? 25 : (int)request()->get("paginate");
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
            AdminColumn::checkbox('')->setOrderable(false)->setWidth('50px'),

            AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center')->setOrderable('id'),

            AdminColumn::image('logo_file', 'Лого')->setImageWidth('48px'),

            AdminColumn::link('title', 'Компания/Имя', 'torgBuyer.name')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
            }),

            AdminColumn::text('email', 'E-mail')->setWidth('180px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.last_login', 'Последний вход')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('torgBuyer.last_login', $direction);
                })->setHtmlAttribute('class', 'text-center')->setOrderable(false),

            AdminColumn::custom('Окончание пакета', function (\Illuminate\Database\Eloquent\Model $model){
                $package = !$model['torgBuyer']['buyerPacksOrders']->isEmpty() ? $model['torgBuyer']['buyerPacksOrders'][0]['endt'] : '';
                return "<div class='row-text text-center'>{$package}</div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Войти', function (\App\Models\Comp\CompItems $compItems){
                $WWWHOST = 'https://agrotender.com.ua/';
                return "<a href=\"".$WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($compItems['torgBuyer']['login'])."&buyerpass=".stripslashes($compItems['torgBuyer']['passwd'])."\" target='_blank' class='btn-success btn btn-xs' title='' data-toggle='tooltip' data-original-title='Залогиниться'><i class='fas fa-user-lock'></i></a>";
            })->setHtmlAttribute('class', 'text-center')->setOrderable(false),
        ];


        $display = AdminDisplay::datatables()
            ->setApply(function ($query){
                $query->where('trader_price_avail', 1)->orderBy('id', 'desc');
            })
            ->setName('firstdatatables')
            //->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
//            ->setActions([
//                AdminColumn::action('id', ' Удалить')->setAction(route('delete_traders_admin'))->useGet(),
//            ])
            ->setFilters(
                AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                    $query->where('id', $value);
                }),

                AdminDisplayFilter::custom('phone')->setCallback(function ($query, $value) {
                    $query->where('phone', $value);
                }),

                AdminDisplayFilter::custom('author')->setCallback(function ($query, $value) {
                    $query->whereHas('torgBuyer', function ($query) use ($value) {
                        $query->where('name', $value);
                    });
                }),

                AdminDisplayFilter::custom('email')->setCallback(function ($query, $value) {
                    $query->whereHas('torgBuyer', function ($query) use ($value) {
                        $query->where('login', $value);
                    });
                })
            );

        $display->getColumnFilters()->setPlacement('card.heading');

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
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title', 'Название')->required(),
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
