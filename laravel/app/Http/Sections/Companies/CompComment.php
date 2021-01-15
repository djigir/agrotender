<?php

namespace App\Http\Sections\Companies;

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
 * Class CompComment
 *
 * @property \App\Models\Comp\CompComment $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompComment extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Отзывы компаний';

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
            AdminColumn::text('author_id', 'User ID')->setWidth('90px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('author', 'Автор', 'add_date')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                })->setHtmlAttribute('class', 'text-center')->setWidth('180px'),

            AdminColumn::text('compItem.title', 'Компания')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('item_id', $direction);
                })->setHtmlAttribute('class', 'text-center')->setWidth('200px'),

            AdminColumn::text('compCommentLang.content', 'Отзыв')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                })->setWidth('420px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Показать на сайте', function (Model $model) {
                $show = 'Нет';
                $style = '';
                if ($model->visible == 1) {
                    $show = 'Да';
                    $style = 'color:red';
                }
                return "<div class='row-text text-center' style='{$style}'>{$show}</div>";
            })->setHtmlAttribute('class', 'text-center')->setWidth('50px'),

            AdminColumn::custom('Жалобы', function (Model $model) {
                return "<div class='row-link text-center'>
                            <a href='{$model->UsersComplains()}?UsersComplains[comment_id]={$model->id}' target='_blank'>{$model['compCommentComplains']->count()}</a>
                        </div>";
            })->setHtmlAttribute('class', 'text-center')->setWidth('50px'),

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
                ->setColumnName('author_id')
                ->setPlaceholder('По ID'),

            AdminColumnFilter::text()
                ->setColumnName('compCommentLang.content')
                ->setOperator('contains')
                ->setPlaceholder('По отзыву'),

            AdminColumnFilter::text()
                ->setColumnName('author')
                ->setOperator('contains')
                ->setPlaceholder('По автору')

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
                AdminFormElement::text('author', 'Автор')->required(),
                AdminFormElement::textarea('compCommentLang.content_plus', 'Преимущества')->setRows(4),
                AdminFormElement::textarea('compCommentLang.content_minus', 'Недостатки')->setRows(4),

                AdminFormElement::datetime('add_date')
                    ->setVisible(true)
                    ->setReadonly(false),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([
                AdminFormElement::textarea('compCommentLang.content', 'Текст'),
                AdminFormElement::select('visible', 'Показать на сайте')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет',
                    ]),
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
