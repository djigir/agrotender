<?php

namespace App\Http\Sections\TraderPrices;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
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
 * Class TradersProductsSell
 *
 * @property \App\Models\Traders\TradersProductsSell $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TradersProductsSell extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Закупки';

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
                ->setWidth('150px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('tradersProductLang.name', 'Название')
                ->setOrderable(function ($query, $direction){
                    $query->OrderBy('group_id', $direction);
                })
                ->setWidth('350px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('url', 'URL')->setWidth('250px')->setHtmlAttribute('class', 'text-center'),
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
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                AdminDisplayFilter::custom('group_id')->setCallback(function ($query, $value) {
                    $query->where('group_id', $value);
                }),
                AdminDisplayFilter::custom('name')->setCallback(function ($query, $value) {
                    $query->whereHas('tradersProductLang', function ($query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%');
                    });
                })
            );

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

                AdminFormElement::select('group_id', 'Группа товаров')
                    ->setModelForOptions(\App\Models\Traders\TradersProductGroups::class)
                    ->setDisplay('tradersProductGroupsLang.name')
                    ->required(),

                AdminFormElement::text('tradersProductLang.name', 'Название')->required(),

                AdminFormElement::text('url', 'URL'),

                AdminFormElement::hidden('tradersProductLang.lang_id')->setDefaultValue('1'),

                AdminFormElement::image('icon_filename', 'Иконка'),

            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([

                AdminFormElement::ckeditor('tradersProductLang.descr', 'Описание'),


            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),

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
