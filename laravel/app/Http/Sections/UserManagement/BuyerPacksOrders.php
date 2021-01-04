<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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
    const PAYMENTH_TYPE = [
        1 => 'Приват 24',
        2 => 'Карта',
        3 => 'По счету',
    ];

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
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
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
                $post = 'отсутствует';
                if ($model['torgPost']){
                    $post = $model['torgPost']->title;
                }
                $style = '';
                if ($post == 'отсутствует'){
                    $style = 'pointer-events: none; cursor: default; color:black';
                }
                return "<div class='row-link'>
                        <a href='https://agrotender.com.ua/board/post-{$model->post_id}' style='$style'>{$post}</a>
                    </div>";
            }),

            AdminColumn::custom('Активно', function (Model $model) {
                $status_date = Carbon::now();
                $diff_date = $status_date->diffInDays($model->endt);

                $is_active = 'Нет актив.';
                $style = '';

                if ($diff_date > 0) {
                    $is_active = 'Актив.';
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

            AdminColumn::text('torgPost.id', 'ID Объяв.')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),

//            AdminColumn::custom('Метод', function (\Illuminate\Database\Eloquent\Model $model){
//                $paymeth_type = self::PAYMENTH_TYPE;
//                return "<div class='row-text'>{$paymeth_type[$model['pyBill']->paymeth_type]}</div>";
//            }),
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
                ->setModelForOptions(\App\Models\Buyer\BuyerPacksOrders::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('name')
                ->setPlaceholder('All names'),

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
