<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Torg\TorgBuyer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Column\Url;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
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
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Редактир. компаний';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
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
        $c = \App\Models\Comp\CompItems::with('torgBuyer')->limit(1)->get();
        $t2i = \App\Models\Comp\CompTopicItem::with('compTopic')->first();

//        $t = \App\Models\Comp\CompTopic::with('compItemWithItemTopic')->limit(1)->get();
//        dd($c);

        /*AdminColumn::custom('ID', function ($id){
            return \URL::route('company.index', [$id]);
        })*/

        $columns = [
            /*AdminColumn::link('id', 'ID')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),*/

            AdminColumn::url('id', 'ID')
                ->setText('id'/*, route('company.index', 'id')*/)
                ->setIcon(false)
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),


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
                ->setWidth('190px')
                ->setHtmlAttribute('class', 'text-center'),


//            AdminColumn::text('', 'Т'),
//
//            AdminColumn::text('', 'З'),
//
//            AdminColumn::text('', 'У'),

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
                })

                /*->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),*/
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
                ->setModelForOptions(\App\Models\Comp\CompTopic::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('title')
                ->setColumnName('compTopicItem.topic_id')
                ->setPlaceholder('Все секции'),

            AdminColumnFilter::select()
                ->setOptions([
                    1 => 'Трейдер (закуп.)',
                    1 => 'Трейдер (продажи.)',
                ])
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setColumnName('trader_price_avail')
                ->setPlaceholder('Все компании'),

            /* trader_price_sell_avail=1  - Трейдер продажи */

            /* trader_price_avail=1   - Трейдер закуп */

            AdminColumnFilter::text()
                ->setColumnName('title')
                ->setOperator('contains')
                ->setPlaceholder('По названию компании'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.login')
                ->setPlaceholder('Фильтровать по E-mail'),

            AdminColumnFilter::text()
                ->setColumnName('phone')
                ->setPlaceholder('по Тел.'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.name')
                ->setOperator('contains')
                ->setPlaceholder('по Автору'),

            AdminColumnFilter::text()
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

                AdminFormElement::image('logo_file', 'Лого'),

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

                AdminFormElement::text('trader_sort', 'Приоретет'),
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

                AdminFormElement::text('trader_sort_sell', 'Приоретет'),
                AdminFormElement::html('<hr>'),


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

                AdminFormElement::text('trader_sort_forward', 'Приоретет'),
                AdminFormElement::html('<hr>'),


                AdminFormElement::select('site_pack_id', 'Пакет размещения')
                    ->setModelForOptions(BuyerTarifPacks::class)
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title'),

                AdminFormElement::number('rate_admin1', 'К рейтинга Admin1'),
                AdminFormElement::number('rate_admin2', 'К рейтинга Admin2'),


            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
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
