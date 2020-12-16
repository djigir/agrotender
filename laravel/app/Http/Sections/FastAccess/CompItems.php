<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
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
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $c = \App\Models\Comp\CompItems::with('compTopic')->limit(1)->get();
        $t2i = \App\Models\Comp\CompTopicItem::with('compTopic')->first();


        $t = \App\Models\Comp\CompTopic::with('compTopicItem')->limit(1)->get();
//        dd($t);

        $columns = [
            AdminColumn::text('id', 'ID')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::image('logo_file', 'Лого'),

            AdminColumn::link('title', 'Компания')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.name', 'Ф.И.О')
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.login', 'Логин'),

            AdminColumn::text('region.name', 'Область')
                ->setWidth('140px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('add_date', 'Дата рег.')
                ->setWidth('130px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.last_login', 'Последн. вход')
                ->setWidth('130px')
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
                ->setWidth('105px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('buyerTarifPacks.title', 'Пакет')
                ->setWidth('130px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::count('compComment', 'Отзывов')
                ->setWidth('83px')
                ->setHtmlAttribute('class', 'text-center')

                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),
        ];


        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
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
                ->setColumnName('id')
                ->setPlaceholder('Все секции'),

            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Comp\CompItems::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('trader_price_sell_avail')
                ->setColumnName('trader_price_sell_avail')
                ->setPlaceholder('Все Пакеты'),


            /* trader_price_sell_avail = 1  - Трейдер продажи */

            /* trader_price_avail = 1   - Трейдер закуп */


            AdminColumnFilter::text('id')
                ->setPlaceholder('Фильтровать по E-mail:'),

            AdminColumnFilter::text()->setPlaceholder('по Тел.'),
            AdminColumnFilter::text()->setPlaceholder('по Автору'),
            AdminColumnFilter::text()->setPlaceholder('по ID'),

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
                AdminFormElement::select('trader_price_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                ]),

                /* trader_price_avail = 1   - Трейдер закуп */

                /*AdminFormElement::select('trader_premium_sell', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                ]),

                AdminFormElement::text('trader_sort_sell', 'Приоретет'),*/

                AdminFormElement::datetime('created_at')
                    ->setVisible(true)
                    ->setReadonly(false)
                ,
                AdminFormElement::html('last AdminFormElement without comma')
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
                AdminFormElement::html('last AdminFormElement without comma')
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
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
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

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
