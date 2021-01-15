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
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class Lenta
 *
 * @property \App\Models\Lenta\Lenta $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Lenta extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Лента';

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
        $columns = [
            AdminColumn::text('id', 'ID')->setWidth('150px')->setHtmlAttribute('class', 'text-center')->setWidth('110px'),
            AdminColumn::text('author', 'Компания')->setHtmlAttribute('class', 'text-center')->setWidth('200px'),
            AdminColumn::link('title', 'Запись в ленте')->setHtmlAttribute('class', 'text-center')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                })->setWidth('400px'),
            AdminColumn::text('add_date', 'Дата создания')->setHtmlAttribute('class', 'text-center')->setWidth('250px'),
            AdminColumn::text('up_dt', 'Дата обновления')->setHtmlAttribute('class', 'text-center') ->setWidth('250px'),
        ];

        $display = AdminDisplay::datatables()
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

                AdminFormElement::text('comp_id', 'ID Компании')
                    ->setReadonly(true),


                AdminFormElement::text('author', 'Кто опубликовал')
                    ->required(),

                AdminFormElement::textarea('title', 'Текст публикации')
                    ->setRows(4),


                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('add_date', 'Дата')
                    ->setVisible(true)
                    ->setReadonly(false)
                ,
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')
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
    /*public function onCreate($payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('author', 'Кто опубликовал')
                    ->required(),

                AdminFormElement::textarea('title', 'Текст публикации')
                    ->setRows(4),


                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('add_date', 'Дата')
                    ->setVisible(true)
                    ->setReadonly(false)
                ,
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
