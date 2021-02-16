<?php

namespace App\Http\Sections\TraderPrices;

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
 * Class TradersProductGroups
 *
 * @property \App\Models\Traders\TradersProductGroups $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TradersProductGroups extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Группы Товаров';

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
            AdminColumn::text('sort_num', 'Сортировка')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('sort_num', $direction);
            })->setWidth('120px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::image('icon_filename', 'Иконка')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('tradersProductGroupsLang.name', 'Название')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                })
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setApply(function ($query){
                $query->where('acttype', 0);
            })
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

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

                AdminFormElement::text('tradersProductGroupsLang.name', 'Название группы')
                    ->required(),

                AdminFormElement::text('url', 'URL'),

//                AdminFormElement::image('icon_filename', 'Иконка'),

                AdminFormElement::number('sort_num', 'Порядковый номер'),

                AdminFormElement::html('<hr>'),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::ckeditor('tradersProductGroupsLang.descr', 'Описание'),

                AdminFormElement::hidden('tradersProductGroupsLang.item_id')->setDefaultValue($id),

                AdminFormElement::hidden('tradersProductGroupsLang.lang_id')->setDefaultValue(1),

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
