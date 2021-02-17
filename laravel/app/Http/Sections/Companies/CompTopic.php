<?php

namespace App\Http\Sections\Companies;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\Comp\CompTgroups;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class CompTopic
 *
 * @property \App\Models\Comp\CompTopic $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompTopic extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Разделы';

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
            AdminColumn::text('id', 'ID')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('title', 'Рубрики')
                ->setSearchCallback(function ($column, $query, $search) {
                    return $query->orWhere('title', 'like', '%' . $search . '%');
                })->setOrderable('title')->setHtmlAttribute('class', 'text-center')->setWidth('350px'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                AdminDisplayFilter::custom('group_id')->setCallback(function ($query, $value) {
                    $query->where('menu_group_id', $value);
            }));

//        $display->setColumnFilters([
//            AdminColumnFilter::select()
//                ->setModelForOptions(\App\Models\Comp\CompTgroups::class, 'title')
//                ->setLoadOptionsQueryPreparer(function ($element, $query) {
//                    return $query;
//                })
//                ->setDisplay('title')
//                ->setColumnName('menu_group_id')
//                ->setPlaceholder('Все Рубрики'),
//        ]);


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
                AdminFormElement::select('parent_id', 'Родительский раздел')
                    ->setModelForOptions(\App\Models\Comp\CompTopic::class),

                AdminFormElement::select('menu_group_id', 'В группе (только для 1го уровня)')
                    ->setModelForOptions(CompTgroups::class)->required(),

                AdminFormElement::text('title', 'Название рубрики')->required(),

                AdminFormElement::html('<span class="other-params">Другие параметры</span> <hr>'),
                AdminFormElement::text('sort_num', 'Порядковый номер'),
//                AdminFormElement::select('parent_id', 'Показывать на сайте')
//                    ->setOptions([
//                        0 => 'Нет',
//                        1 => 'Да',
//                ]),
                AdminFormElement::ckeditor('page_keywords', 'Keywords'),


            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-6')->addColumn([
                AdminFormElement::html('<span class="seo-data-title">Seo данные</span> <hr>'),
                AdminFormElement::text('page_h1', 'H1 заголовок'),
                AdminFormElement::text('page_title', 'Title'),
                AdminFormElement::ckeditor('page_descr', 'Description'),
                AdminFormElement::ckeditor('descr', 'Описание'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6'),
        ]);

        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'cancel' => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('parent_id', 'Родительский раздел')
                    ->setModelForOptions(\App\Models\Comp\CompTopic::class),

                AdminFormElement::select('menu_group_id', 'В группе (только для 1го уровня)')
                    ->setModelForOptions(CompTgroups::class, 'title'),

                AdminFormElement::text('title', 'Название новой рубрики')->required(),
                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-6')->addColumn([
                AdminFormElement::number('sort_num', 'Порядковый номер'),
//                AdminFormElement::select('parent_id', 'Показывать на сайте')
//                    ->setOptions([
//                        0 => 'Нет',
//                        1 => 'Да',
//                    ]),
                AdminFormElement::ckeditor('descr', 'Описание'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6'),
        ]);

        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'cancel' => (new Cancel()),
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
