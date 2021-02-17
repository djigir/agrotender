<?php

namespace App\Http\Sections\Companies;

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
 * Class CompTgroups
 *
 * @property \App\Models\Comp\CompTgroups $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompTgroups extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Группы разделов';

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
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('title', 'Название')
                ->setHtmlAttribute('class', 'text-center')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('title', 'like', '%'.$search.'%');
                })
                ->setOrderable('title'),

            AdminColumn::datetime('add_date', 'Созданно')
                ->setHtmlAttribute('class', 'text-center')
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
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
    public function onEdit($id = null, $payload = [], $type = null)
    {
        $update_field = null;

        if($type == 'create'){
            $update_field = AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now());
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title', 'Название')->required(),
                AdminFormElement::number('sort_num', 'Сортировка'),
                AdminFormElement::html('<hr>'),
                AdminFormElement::hidden('mod_date')->setDefaultValue(Carbon::now()),
                $update_field
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
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
