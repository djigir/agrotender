<?php

namespace App\Http\Sections\AlgorithmManagement;

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
 * Class ContactOptions
 *
 * @property \App\Models\Contact\ContactOptions $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ContactOptions extends Section implements Initializable
{
    const LABELS = [
        1 => 'Контактный E-Mail',
        2 => 'E-Mail Службы Поддержки',
        3 => 'Телефон 1',
        4 => 'Телефон 2',
        5 => 'Телефон 3',
        6 => 'Адрес',
        7 => 'Skype',
        8 => 'ICQ',
    ];
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Контакты';

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
        $data = \App\Models\Contact\ContactOptions::pluck('value', 'id');

        $columns = [
            AdminColumn::custom(self::LABELS[1], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[1]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[2], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[2]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[3], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[3]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[4], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[4]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[5], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[5]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[6], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[6]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[7], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[7]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[8], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[8]}</div>";
            })->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
           // ->setOrder([[0, 'asc']])
           // ->setDisplaySearch(true)
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
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('value', self::LABELS[$id]),
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
//    public function onCreate($payload = [])
//    {
//        return $this->onEdit(null, $payload);
//    }
//
//    /**
//     * @return bool
//     */
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
