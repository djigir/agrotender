<?php

namespace App\Http\Sections\News;

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
 * Class AgtNewsComment
 *
 * @property \App\Models\News\NewsComment $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AgtNewsComment extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Комментарии к новостям';

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
        $c = \App\Models\News\NewsComment::with('newsLang')->where('author', 'НИКОЛАЙ')->get();
//        dd($c);

        $columns = [
            AdminColumn::text('id', 'ID')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('author', 'Автор', 'add_date')
                ->setWidth('200px')
                ->setHtmlAttribute('class', 'text-center')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('author', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),

            AdminColumn::text('newsLang.content', 'Комментарий')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('author_email', $direction);
                }),


            AdminColumn::boolean('visible', 'Показать на сайте'),

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
                ->setColumnName('newsLang.content')
                ->setOperator('contains')
                ->setPlaceholder('По комментарию'),

            AdminColumnFilter::text()
                ->setColumnName('author')
                ->setOperator('contains')
                ->setPlaceholder('По автору'),

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
                AdminFormElement::text('author', 'Автор')
                    ->required(),

                AdminFormElement::textarea('newsLang.content', 'Коментарий'),

                AdminFormElement::select('visible', 'Показывать на сайте')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),


                AdminFormElement::html('<span style="font-weight: bold;">Дата создания</span>'),
                AdminFormElement::datetime('add_date')
                    ->setVisible(true)
                    ->setReadonly(false)
                ,

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4'),
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
