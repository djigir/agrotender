<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\ADV\AdvTorgPost;
use App\Models\Buyer\BuyerTarifPacks;
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
 * Class BuyerPacksOrders
 *
 * @property \App\Models\Buyer\BuyerPacksOrders $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BuyerPacksOrders extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Пакеты услуг пользователя';

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
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {

        $columns = [
            AdminColumn::text('id', 'ID')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('tarif.title', 'Пакет', 'add_date')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                })->setWidth('250px'),

            AdminColumn::custom('Объявление', function (Model $model){
                $post = 'Объявление не существует';
                if ($model['torgPost']){
                    $post = $model['torgPost']->title;
                }
                $style = '';
                if ($post == 'Объявление не существует'){
                    $style = 'pointer-events: none; cursor: default; color:black';
                }
                return "<div class='row-link'>
                        <a href='https://agrotender.com.ua/board/post-{$model->post_id}' style='$style'>{$post}</a>
                    </div>";
            }),

            AdminColumn::custom('Активно', function (Model $model) {
                $start = $model->stdt;
                $end = $model->endt;
                $now = Carbon::now();

                $is_active = 'Нет';
                $style = '';

                if ($start <= $now && $end >= $now){
                    $is_active = 'Да';
                    $style = 'color:red;';
                }

                return "<div class='row-text text-center' style='{$style}'>{$is_active}</div>";

            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::datetime('stdt', 'Начало')
                ->setWidth('200px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::datetime('endt', 'Конец')
                ->setWidth('200px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('tarif.cost', 'Цена')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Метод', function (\Illuminate\Database\Eloquent\Model $model){
                $paymeth_type = $model['pyBill'];

                if ($paymeth_type == null) {
                    $pay_method = '-';
                }

                if ($paymeth_type['paymeth_type'] == 1) {
                    $pay_method = 'Приват 24';
                }
                if ($paymeth_type['paymeth_type'] == 2){
                    $pay_method = 'Карта';
                }
                if  ($paymeth_type['paymeth_type'] == 3){
                    $pay_method = 'По счету';
                }

                return "<div class='row-text' style='font-weight:bold;'>{$pay_method}</div>";
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgPost.id', 'ID Объяв.')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('TorgBuyerPackOreders')
            );

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Buyer\BuyerTarifPacks::class, 'title')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('title')
                ->setColumnName('pack_id')
                ->setPlaceholder('Все типы объявления'),

            AdminColumnFilter::text()
                ->setHtmlAttribute('class', 'ID_search')
                ->setColumnName('id')
                ->setPlaceholder('По ID'),

            AdminColumnFilter::text()
                ->setColumnName('post_id')
                ->setPlaceholder('По ID Объявления'),

            AdminColumnFilter::text()
                ->setColumnName('torgPost.title')
                ->setPlaceholder('По Тексту Объявления'),

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
                AdminFormElement::text('name', 'Name')
                    ->required(),


            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([

                AdminFormElement::text('id', 'ID')->setReadonly(true),

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
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
    public function onCreate($payload = [])
    {
        /* если перешел с вкладки зарегистрированые пользователи */

        $user_id = request()->get('TorgBuyerPackOreders')['user_id'];

        $user = \App\Models\Torg\TorgBuyer::find($user_id);

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([

                AdminFormElement::html(function (Model $model) use ($user) {
                    return "<div class='form-group form-element-text'><label for='name' class='control-label'>Имя</label>
                            <input class='form-control' type='text' id='name' name='name' value='{$user->name}' readonly='readonly'>
                        </div>";
                }),

                AdminFormElement::hidden('user_id')->setDefaultValue($user_id),

                AdminFormElement::custom(function (Model $model) {
                    $model->stdt = Carbon::now();
                }),

                AdminFormElement::custom(function (Model $model) {
                    $days = 30;
                    $model->endt = Carbon::now()->addDays($days);
                }),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

                AdminFormElement::select('pack_id', 'Пакет')
                    ->setModelForOptions(BuyerTarifPacks::class, 'title')
                    ->setLoadOptionsQueryPreparer(function ($item, $query) {
                        return $query->where('pack_type', 0);
                    })->setDisplay('title'),


            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::textarea('comments', 'Комментарии')
                    ->setDefaultValue('Добавлено админом+')
                    ->setRows(4),

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
        ]);

        /* если на прямую кликнул на тарифы */

        if (!$user_id) {

            $form = AdminForm::card()->addBody([
                AdminFormElement::columns()->addColumn([

                    AdminFormElement::number('user_id', 'ID пользователя'),

                    AdminFormElement::custom(function (Model $model) {
                        $model->stdt = Carbon::now();
                    }),

                    AdminFormElement::custom(function (Model $model) {
                        $days = 30;
                        $model->endt = Carbon::now()->addDays($days);
                    }),

                    AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

                    AdminFormElement::select('pack_id', 'Пакет')
                        ->setModelForOptions(BuyerTarifPacks::class, 'title')
                        ->setLoadOptionsQueryPreparer(function ($item, $query) {
                            return $query->where('pack_type', 0);
                        })->setDisplay('title'),


                ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                    AdminFormElement::textarea('comments', 'Комментарии')
                        ->setDefaultValue('Добавлено админом+')
                        ->setRows(4),

                ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),

            ]);

        }


        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'save_and_create' => new SaveAndCreate(),
            'cancel' => (new Cancel()),
        ]);

        return $form;
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
