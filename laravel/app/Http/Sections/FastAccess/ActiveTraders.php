<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Comp\CompTgroups;
use App\Models\Traders\TradersPrices;
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
 * Class ActiveTraders
 *
 * @property \App\Models\Comp\CompItemsActive $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ActiveTraders extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Активные трейды';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        //dd(\App\Models\Comp\CompItems::first()->tradersPrices);
//        dd(\App\Models\Comp\CompItems::find(6614)->tradersPrices);
//        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
            })->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center')
                ->setOrderable('id'),

            AdminColumn::image('logo_file', 'Лого')->setImageWidth('48px'),
            AdminColumn::text('title', 'Название'),

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


            AdminColumn::datetime('tradersPrices.dt', 'Последнее обновление')
                ->setSearchable(true)
                ->setHtmlAttribute('class', 'text-center')
                ->setFormat('Y-m-d'),

//            AdminColumn::custom('Последнее обновление', function(\Illuminate\Database\Eloquent\Model $model){
//                return $model['tradersPrices']['dt'];
//            })->setHtmlAttribute('class', 'text-center')
//                ->setOrderCallback(function($column, $query, $direction){
//                    return $query->join('traders_prices', 'comp_items.author_id', '=', 'traders_prices.buyer_id')->orderBy('dt', $direction);
//            }),

            AdminColumn::custom('Дней назад', function (\Illuminate\Database\Eloquent\Model $model) {
                $last_update = $model['tradersPrices']['dt'];
                $d = Carbon::parse($last_update);
                $now = Carbon::now();
                return $d->diffInDays($now);
            })->setHtmlAttribute('class', 'text-center'),

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

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
//    public function onEdit($id = null, $payload = [])
//    {
//        $form = AdminForm::card()->addBody([
//            AdminFormElement::columns()->addColumn([
//                AdminFormElement::text('name', 'Name')
//                    ->required()
//                ,
//                AdminFormElement::html('<hr>'),
//                AdminFormElement::datetime('created_at')
//                    ->setVisible(true)
//                    ->setReadonly(false)
//                ,
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
//                AdminFormElement::text('id', 'ID')->setReadonly(true),
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
//        ]);
//
//        $form->getButtons()->setButtons([
//            'save'  => new Save(),
//            'save_and_close'  => new SaveAndClose(),
//            'save_and_create'  => new SaveAndCreate(),
//            'cancel'  => (new Cancel()),
//        ]);
//
//        return $form;
//    }

    /**
     * @return FormInterface
     */
//    public function onCreate($payload = [])
//    {
//        return $this->onEdit(null, $payload);
//    }

    /**
     * @return bool
     */
//    public function isDeletable(Model $model)
//    {
//        return true;
//    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
