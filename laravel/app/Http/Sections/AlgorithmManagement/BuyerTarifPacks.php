<?php

namespace App\Http\Sections\AlgorithmManagement;

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
 * Class BuyerTarifPacks
 *
 * @property \App\Models\Buyer\BuyerTarifPacks $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BuyerTarifPacks extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Пакеты услуг';

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
            AdminColumn::text('title', 'Содержание записей')->setWidth('100px')->setHtmlAttribute('class', 'text-center')->setOrderable(false),
            AdminColumn::text('add_date', 'Дата')->setWidth('80px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('active', 'Показывать на сайте'),
            AdminColumn::text('cost', 'Цена')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Период', function (\Illuminate\Database\Eloquent\Model $model){
                $period_type = [
                    0 => 'День',
                    1 => 'Месяц',
                    2 => 'Год',
                ];

                return "<div class='row-text text-center'>{$model->period} ({$period_type[$model->period_type]})</div>";
            })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),


            AdminColumn::text('adv_num', 'Кол-во объяв')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Тип услуги', function (\Illuminate\Database\Eloquent\Model $model){
                $type_service = [
                    0 => 'Количество объявлений',
                    1 => 'Объявление в топ',
                    2 => 'UP Объявления',
                    3 => 'Выделение цветом',
                ];

                return "<div class='row-text text-center'>{$type_service[$model->pack_type]}</div>";
            })->setWidth('80px')->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[1, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param string|null $type
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [], $type = '')
    {
        $create_element = null;
        if($type == 'create'){
            $create_element =  AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now());
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('pack_type', 'Тип услуги', [
                    0 => 'Количество объявлений',
                    1 => 'Объявление в топ',
                    2 => 'UP Объявления',
                    3 => 'Выделение цветом',
                ])->setDefaultValue(0)->required(),
                AdminFormElement::text('title', 'Имя')->required(),
                AdminFormElement::ckeditor('content', 'Текст'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::select('active', 'Показывать на сайте', [
                    0 => 'Нет',
                    1 => 'Да',
                ])->setDefaultValue(1)->required(),
                AdminFormElement::number('cost', 'Стоимость (грн.)')->required(),
                AdminFormElement::select('period_type', 'Период', [
                    0 => 'День',
                    1 => 'Месяц',
                    2 => 'Год',
                ])->setDefaultValue(0)->required(),
                AdminFormElement::number('period', 'Длительность периода')->required(),
                AdminFormElement::number('adv_num', 'Кол-во объявлений')->required(),
                AdminFormElement::number('sort_num', 'Порядковый номер')->required(),
                $create_element
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-3'),
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
        return $this->onEdit(null, $payload, 'create');
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
