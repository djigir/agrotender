<?php

namespace App\Http\Sections\Companies;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Comp\CompItems;
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
 * Class CompNews
 *
 * @property \App\Models\Comp\CompNews $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompNews extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = ' Новости Компаний';

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
            AdminColumn::text('id', 'ID')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('title', 'Новость', 'add_date')
                ->setWidth('400px')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),

            AdminColumn::text('companyItem.title', 'Компания')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('comp_id', $direction);
                })
                ->setWidth('220px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::boolean('visible', 'Показывать на сайте'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::text()
                ->setColumnName('title')
                ->setOperator('contains')
                ->setPlaceholder('Поиск по новости'),

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
                AdminFormElement::text('title', 'Новость')->required(),
                AdminFormElement::select('visible', 'Показать на сайте')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет',
                    ]),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([
                AdminFormElement::ckeditor('content', 'Содержание'),
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
    /*public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
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
