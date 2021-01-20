<?php

namespace App\Http\Sections\Companies;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class CompCommentComplains
 *
 * @property \App\Models\Comp\CompCommentComplains $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompCommentComplains extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Жалобы на отзывы';

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
                ->setWidth('60px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('torgBuyer.name', 'Автор', 'add_date')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('author_id', $direction);
                })->setWidth('220px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('msg', 'Жалоба'),

            AdminColumn::datetime('add_date', 'Дата')
                ->setWidth('165px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('ip', 'IP')
                ->setWidth('140px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Просмотрено', function (Model $model) {
                $viewed = 'Да';
                $style = '';
                if ($model->viewed == 0) {
                    $viewed = 'Нет';
                    $style = 'color:red;';
                }
                return "<div class='row-text text-center' style='{$style}'>{$viewed}</div>";
            }),

            AdminColumn::custom('Обработано', function (Model $model) {
                $status = 'Обработать';
                $style = 'color:red;';
                if ($model->status == 1) {
                    $status = 'Исправлено';
                    $style = '';
                }
                return "<div class='row-text text-center' style='{$style}'>{$status}</div>";
            })->setWidth('130px')->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('UsersComplains')
            );

        $display->setColumnFilters([

            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setPlaceholder('По ID'),

            AdminColumnFilter::text()
                ->setColumnName('msg')
                ->setOperator('contains')
                ->setPlaceholder('По отзыву'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.name')
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

                AdminFormElement::text('torgBuyer.name', 'Автор')
                    ->required(),


                AdminFormElement::select('viewed', 'Просмотрено')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет',
                    ]),

                AdminFormElement::select('status', 'Просмотрено')
                    ->setOptions([
                        0 => 'Новый',
                        1 => 'Обработан',
                    ]),


            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([

                AdminFormElement::ckeditor('msg', 'Жалоба')
                    ->required(),

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
