<?php

namespace App\Http\Sections\UserManagement;

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
 * Class PyBillDoc
 *
 * @property \App\Models\Py\PyBillDoc $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class PyBillDoc extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Документы по оплате';

    /**
     * @var string
     */
    protected $alias;

    const TYPE_DOC = [
        0 => 'Счёт',
        1 => 'Акт',
        2 => 'Скан-копия',
    ];

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
            AdminColumn::text('id', 'ID')->setWidth('10px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('add_date', 'Дата')->setWidth('10px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Тип', function (\Illuminate\Database\Eloquent\Model $model) {
                $type_doc = self::TYPE_DOC[$model->doc_type];
                return "<div class='row-link'>{$type_doc}</div>";
            })->setWidth('10px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Название', function (\Illuminate\Database\Eloquent\Model $model) {
                $file = 'https://agrotender.com.ua/'.$model->filename;
                return "<div class='row-link'><a href='{$file}' target='_blank'>{$file}</a></div>";
            })->setWidth('10px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Плательщик', function (\Illuminate\Database\Eloquent\Model $model) {
                $name = $model['pyBillDate']['torgBuyer'][0]['name'];
                return "<div class='row-link'>{$name}</div>";
            })->setWidth('10px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
//            ->setOrder([[0, 'asc']])
//            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

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
//    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('buyer_id', 'ID баэра')->required(),
                AdminFormElement::text('bill_id', 'ID билла')->required(),
                AdminFormElement::text('doc_type', 'Тип документа')->required(),
                AdminFormElement::text('filename', 'Файл')->required(),
                AdminFormElement::text('add_date', 'Дата')->required(),
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
