<?php

namespace App\Http\Sections\TraderPrices;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Regions\Regions;
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
 * Class TradersPorts
 *
 * @property \App\Models\Traders\TradersPorts $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TradersPorts extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Порты';

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
                ->setWidth('70px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('portsLang.portname', 'Название порта')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('active', $direction);
                })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('regions.name', 'Область')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('obl_id', $direction);
                })
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('url', 'URL')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::boolean('active', 'Отображать на сайте')
                ->setWidth('200px')
                ->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(30)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(Regions::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setPlaceholder('Все области'),

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

                AdminFormElement::select('obl_id', 'Область')
                    ->setModelForOptions(Regions::class, 'name')
                    ->required(),


                    AdminFormElement::text('portsLang.portname', 'Название порта')
                        ->required(),

                AdminFormElement::text('url', 'URL')
                    ->required(),

                AdminFormElement::select('active', 'Показать на сайте')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет',
                    ])
                    ->required(),

                AdminFormElement::textarea('portsLang.p_title', 'Title')
                    ->setRows(2)
                    ->required(),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::text('portsLang.p_h1', 'H1')
                    ->required(),

                AdminFormElement::textarea('portsLang.p_descr', 'Описание')
                    ->setRows(3)
                    ->required(),

                AdminFormElement::textarea('portsLang.p_content', 'Content')
                    ->setRows(3)
                    ->required(),

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
