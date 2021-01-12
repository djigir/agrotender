<?php

namespace App\Http\Sections\PagesManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Modes\Popup\PopupDlgsViews;
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
 * Class PopupDlgs
 *
 * @property \App\Models\Popup\PopupDlgs $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class PopupDlgs extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Всплывающие окна';

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
            AdminColumn::custom('Содержание записей', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text text-center'>{$model['popupDlgsLang']['title']} [{$model->dtime}]</div>";
            })->setWidth('350px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Показывать', function (\Illuminate\Database\Eloquent\Model $model){
                $style = '';
                $display = [
                    0 => 'Нет',
                    1 => 'Да',
                ];
                if($model->first_page == 1){
                    $style = 'color:red';
                }
                return "<div style='{$style}' class='row-text text-center'>{$display[$model->first_page]}</div>";
            })->setWidth('40px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Активно', function (\Illuminate\Database\Eloquent\Model $model){
                $is_active = $model->end_date < \Carbon\Carbon::now() ? 'Нет' : 'Да';
                $style = '';
                if($is_active == 'Да'){
                    $style = 'color:red';
                }
                return "<div style='{$style}' class='row-text text-center'>{$is_active}</div>";
            })->setWidth('40px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('До даты', function (\Illuminate\Database\Eloquent\Model $model){
                $date = \Carbon\Carbon::parse($model->end_date)->format('d.m.Y');
                return "<div class='row-text text-center'>{$date}</div>";
            })->setWidth('80px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('urlgo', 'URL')->setWidth('150px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Просм', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text text-center'>{$model['popupDlgsViews']->count()}</div>";
            })->setWidth('40px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            //->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setApply(function ($query)
        {
            $query->orderBy('end_date', 'desc');
        });

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
                AdminFormElement::datetime('end_date', 'Показывать до:')->setDefaultValue(\Carbon\Carbon::now()->addDay(7)->format('d.m.Y H:i'))->required(),
                AdminFormElement::text('popupDlgsLang.title', 'Заголовок'),
                AdminFormElement::text('popupDlgsLang.btntext', 'Текст кнопки'),
                AdminFormElement::text('urlgo', 'УРЛ перехода'),
                AdminFormElement::hidden('dtime')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::select('first_page', 'Показывать', [
                    0 => 'Нет',
                    1 => 'Да',
                ])->setDefaultValue(0)->required(),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::textarea('popupDlgsLang.content', 'Текст'),
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
